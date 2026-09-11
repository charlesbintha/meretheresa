<?php

namespace App\Services;

use App\Models\SchoolRole;
use App\Models\User;
use App\Support\SchoolPermissions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class SchoolAccounts
{
    public function identity(User $user): array
    {
        return ['id' => $user->id, 'name' => $user->name, 'email' => $user->email, 'phone' => $user->phone ?? '',
            'roleId' => $user->school_role_id, 'roleName' => $user->schoolRole?->name ?? ($user->isSchoolAdministrator() ? 'Administrateur' : 'Sans rôle'),
            'isActive' => $user->is_active, 'lastLogin' => $user->last_login_at?->toIso8601String()];
    }

    public function state(User $user): array
    {
        return ['user' => $this->identity($user), 'permissions' => $user->schoolPermissions(),
            'users' => $user->canSchool('users.manage') ? User::with('schoolRole')->orderBy('name')->get()->map(fn ($u) => $this->identity($u))->all() : [],
            'roles' => $user->canSchool('roles.manage') ? SchoolRole::orderByDesc('is_system')->orderBy('name')->get()->map(fn ($r) => [
                'id' => $r->id, 'name' => $r->name, 'description' => $r->description ?? '', 'permissions' => SchoolPermissions::normalize($r->permissions),
                'isSystem' => $r->is_system, 'userCount' => User::where('school_role_id', $r->id)->count()])->all() : [],
            'permissionCatalog' => $user->canSchool('roles.manage') ? SchoolPermissions::CATALOG : (object) []];
    }

    public function execute(string $action, array $data, ?string $id, User $actor): int
    {
        if ($action !== 'profile') {
            abort_unless($actor->isSchoolAdministrator(), 403);
        }

        return match ($action) {
            'account' => $this->account($data, $id, $actor),
            'account-status' => $this->status($data, $id, $actor),
            'account-password' => $this->password($data, $id),
            'role' => $this->role($data, $id),
            'role-delete' => $this->deleteRole($id),
            'profile' => $this->profile($data, $actor),
            default => abort(404),
        };
    }

    private function validate(array $data, array $rules): array
    {
        if (isset($data['password']) && is_string($data['password']) && strlen($data['password']) > 72) {
            throw ValidationException::withMessages(['password' => 'Le mot de passe est trop long. Utilisez une phrase plus courte.']);
        }
        return Validator::make($data, $rules)->validate();
    }

    private function reject(string $message): never
    {
        throw ValidationException::withMessages(['record' => $message]);
    }

    private function preserveAdmin(User $user, bool $willBeAdmin): void
    {
        if ($user->is_active && $user->isSchoolAdministrator() && ! $willBeAdmin) {
            $others = User::where('id', '!=', $user->id)->where('is_active', true)->where(function ($q) {
                $q->whereHas('schoolRole', fn ($q) => $q->where('is_system', true))
                    ->orWhere(fn ($q) => $q->whereNull('school_role_id')->where('is_school_admin', true));
            })->exists();
            if (! $others) {
                $this->reject('Conservez au moins un administrateur actif.');
            }
        }
    }

    private function revoke(User $user): void
    {
        $user->auth_version++;
        $user->remember_token = null;
        DB::table('sessions')->where('user_id', $user->id)->delete();
    }

    private function account(array $data, ?string $id, User $actor): int
    {
        $v = $this->validate($data, [
            'name' => 'required|string|max:100', 'email' => ['required', 'email', 'max:191', Rule::unique('users', 'email')->ignore($id)],
            'phone' => 'nullable|string|max:25', 'roleId' => 'required|integer|exists:school_roles,id',
            'password' => $id ? 'prohibited' : 'required|string|min:12|max:72|confirmed',
            'password_confirmation' => $id ? 'prohibited' : 'required|string',
        ]);
        $user = $id ? User::findOrFail($id) : new User;
        $role = SchoolRole::findOrFail($v['roleId']);
        if ($id) {
            $this->preserveAdmin($user, $role->is_system && $user->is_active);
            if ($user->id === $actor->id && $user->school_role_id !== $role->id) {
                $this->reject('Faites modifier votre propre rôle par un autre administrateur.');
            }
            if ($user->school_role_id !== $role->id || $user->email !== $v['email']) {
                if ($user->id !== $actor->id) {
                    $this->revoke($user);
                }
            }
            if ($user->id === $actor->id && $user->email !== $v['email']) {
                $this->reject('Modifiez votre adresse e-mail depuis Mon profil avec votre mot de passe actuel.');
            }
        } else {
            $user->password = Hash::make($v['password']);
            $user->is_active = true;
        }
        $user->name = $v['name'];
        $user->email = $v['email'];
        $user->phone = $v['phone'] ?? null;
        $user->school_role_id = $role->id;
        $user->is_school_admin = $role->is_system;
        $user->save();

        return $user->id;
    }

    private function status(array $data, ?string $id, User $actor): int
    {
        $v = $this->validate($data, ['isActive' => 'required|boolean']);
        $user = User::findOrFail($id);
        if ($user->id === $actor->id && ! $v['isActive']) {
            $this->reject('Vous ne pouvez pas désactiver votre propre compte.');
        }
        $this->preserveAdmin($user, (bool) $v['isActive'] && $user->isSchoolAdministrator());
        if ($user->is_active !== (bool) $v['isActive']) {
            $this->revoke($user);
            $user->is_active = (bool) $v['isActive'];
            $user->save();
        }

        return $user->id;
    }

    private function password(array $data, ?string $id): int
    {
        $v = $this->validate($data, ['password' => 'required|string|min:12|max:72|confirmed']);
        $user = User::findOrFail($id);
        if ($user->id === auth()->id()) {
            $this->reject('Modifiez votre mot de passe depuis Mon profil.');
        }
        $this->revoke($user);
        $user->password = Hash::make($v['password']);
        $user->save();

        return $user->id;
    }

    private function profile(array $data, User $user): int
    {
        $v = $this->validate($data, [
            'name' => 'required|string|max:100', 'email' => ['required', 'email', 'max:191', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => 'nullable|string|max:25', 'current_password' => 'nullable|string',
            'password' => 'nullable|string|min:12|max:72|confirmed',
            'roleId' => 'prohibited', 'school_role_id' => 'prohibited', 'is_school_admin' => 'prohibited', 'isActive' => 'prohibited', 'is_active' => 'prohibited',
        ]);
        $sensitive = $v['email'] !== $user->email || ! empty($v['password']);
        if ($sensitive && ! Hash::check($v['current_password'] ?? '', $user->password)) {
            $this->reject('Le mot de passe actuel est incorrect.');
        }
        if ($sensitive) {
            $this->revoke($user);
            if (! empty($v['password'])) {
                $user->password = Hash::make($v['password']);
            }
        }
        $user->name = $v['name'];
        $user->email = $v['email'];
        $user->phone = $v['phone'] ?? null;
        $user->save();

        return $user->id;
    }

    private function role(array $data, ?string $id): int
    {
        $v = $this->validate($data, ['name' => ['required', 'string', 'max:60', Rule::unique('school_roles', 'name')->ignore($id)],
            'description' => 'nullable|string|max:500', 'permissions' => 'present|array', 'permissions.*' => ['string', 'distinct', Rule::in(array_keys(SchoolPermissions::CATALOG))]]);
        $role = $id ? SchoolRole::findOrFail($id) : new SchoolRole;
        if ($role->is_system) {
            $this->reject('Le rôle Administrateur est protégé.');
        }
        $role->name = $v['name'];
        $role->description = $v['description'] ?? null;
        $role->permissions = SchoolPermissions::normalize($v['permissions']);
        $role->save();
        // Existing sessions must authenticate again after their role changes.
        foreach (User::where('school_role_id', $role->id)->get() as $user) {
            $this->revoke($user);
            $user->save();
        }

        return $role->id;
    }

    private function deleteRole(?string $id): int
    {
        $role = SchoolRole::findOrFail($id);
        if ($role->is_system) {
            $this->reject('Le rôle Administrateur est protégé.');
        }
        if (User::where('school_role_id', $role->id)->exists()) {
            $this->reject('Réaffectez les utilisateurs de ce rôle avant de le supprimer.');
        }
        $role->delete();

        return (int) $id;
    }
}

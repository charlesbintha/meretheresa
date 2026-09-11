<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $attributes = ['is_active' => true, 'auth_version' => 1];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function schoolRole()
    {
        return $this->belongsTo(SchoolRole::class, 'school_role_id');
    }

    public function isSchoolAdministrator(): bool
    {
        return $this->school_role_id
            ? (bool) $this->schoolRole?->is_system
            : (bool) $this->is_school_admin;
    }

    public function schoolPermissions(): array
    {
        if (! $this->is_active) {
            return [];
        }
        if ($this->isSchoolAdministrator()) {
            return [...array_keys(\App\Support\SchoolPermissions::CATALOG), 'users.manage', 'roles.manage'];
        }

        return \App\Support\SchoolPermissions::normalize($this->schoolRole?->permissions ?? []);
    }

    public function canSchool(string $permission): bool
    {
        return in_array($permission, $this->schoolPermissions(), true);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'is_school_admin' => 'boolean',
            'is_active' => 'boolean',
            'auth_version' => 'integer',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}

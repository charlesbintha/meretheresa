<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateSchoolAdmin extends Command
{
    protected $signature = 'school:admin {email} {--name=Administration}';

    protected $description = 'Crée ou met à jour le compte administrateur (mot de passe saisi sans affichage).';

    public function handle(): int
    {
        $email = $this->argument('email');
        $password = $this->secret('Mot de passe (12 caractères minimum)');
        $confirm = $this->secret('Confirmez le mot de passe');
        $validator = Validator::make(['email' => $email, 'password' => $password, 'password_confirmation' => $confirm], ['email' => 'required|email|max:191', 'password' => 'required|string|min:12|confirmed']);
        if ($validator->fails()) {
            $this->error($validator->errors()->first());

            return self::FAILURE;
        }
        $user = User::firstOrNew(['email' => $email]);
        $user->name = $this->option('name');
        $user->password = Hash::make($password);
        $user->is_school_admin = true;
        $user->school_role_id = \App\Models\SchoolRole::where('is_system', true)->firstOrFail()->id;
        $user->is_active = true;
        $user->auth_version = ($user->auth_version ?? 0) + 1;
        $user->save();
        $this->info('Compte administrateur enregistré.');

        return self::SUCCESS;
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SchoolAuthController extends Controller
{
    public function login()
    {
        return view('school.login');
    }

    public function store(Request $r)
    {
        $v = $r->validate(['email' => 'required|email', 'password' => 'required|string']);
        if (! Auth::attempt($v + ['is_active' => true])) {
            throw ValidationException::withMessages(['email' => 'Identifiants incorrects ou compte désactivé.']);
        }
        if (! $r->user()->school_role_id && ! $r->user()->isSchoolAdministrator()) {
            Auth::logout();
            throw ValidationException::withMessages(['email' => 'Aucun rôle attribué à ce compte. Contactez un administrateur.']);
        }
        $r->session()->regenerate();
        $r->session()->put('school_auth_version', $r->user()->auth_version);
        $r->user()->forceFill(['last_login_at' => now()])->save();

        return redirect()->intended('/');
    }

    public function logout(Request $r)
    {
        Auth::logout();
        $r->session()->invalidate();
        $r->session()->regenerateToken();

        return redirect()->route('login');
    }
}

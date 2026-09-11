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
        if (! Auth::attempt($v + ['is_school_admin' => true])) {
            throw ValidationException::withMessages(['email' => 'Identifiants incorrects ou accès administrateur non autorisé.']);
        }$r->session()->regenerate();

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

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function __construct()
    {
        // Optionnel : restreindre aux invités seulement
       // $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');  // ta vue register.blade.php
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],
            'type' => ['required', 'in:candidat,recruteur,admin'],
        ]);

        // Créer utilisateur sans connexion automatique
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => $request->type,
        ]);

        // Rediriger vers la page login avec message succès
        return redirect()->route('login')->with('success', 'Inscription réussie, veuillez vous connecter.');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    // Affiche une liste ou tableau de bord profil (optionnel)
    public function index()
    {
        $user = Auth::user();
        return view('ProfilCandidat', compact('user'));
    }

    // Affiche le formulaire d'édition du profil
    public function edit()
    {
        $user = Auth::user();
        return view('edit-profile', compact('user'));
    }

    // Met à jour le profil de l'utilisateur connecté
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'prenom' => 'nullable|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'ville' => 'nullable|string|max:100',
            'about' => 'nullable|string|max:1000',
        ]);

        $user->update($validated);

        return redirect()->route('profile.edit')->with('success', 'Profil mis à jour avec succès.');
    }

    // Affiche le profil d'un utilisateur via son nom (doit être unique)
    public function show($name)
    {
        $user = User::where('name', $name)->firstOrFail();
        return view('ProfilCandidat', compact('user'));
    }
}

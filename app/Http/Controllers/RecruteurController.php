<?php

namespace App\Http\Controllers;
use App\Models\User;

use App\Models\Recruteur;
use Illuminate\Http\Request;

class RecruteurController extends Controller
{

     public function showLoginForm()
    {
        return view('auth.login2'); // Crée aussi cette vue
    }
    // Afficher le dashboard recruteur
    public function dashboard()
    {
        $offres = auth()->user()->recruteur->offres()->withCount('candidats')->get();
        return view('recruteur.dashboard', compact('offres'));
    }

    // Publier une nouvelle offre
    public function storeOffre(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|max:100',
            'description' => 'required',
            'salaire' => 'nullable|numeric'
        ]);

        auth()->user()->recruteur->offres()->create($validated);

        return back()->with('success', 'Offre publiée avec succès!');
    }

    // Consulter les candidatures
    public function candidatures($offre_id)
    {
        $candidats = Offre::findOrFail($offre_id)
                        ->candidats()
                        ->with('user')
                        ->get();

        return view('recruteur.candidatures', compact('candidats'));
    }

public function showProfilRecruteur()
{
    // On suppose que chaque candidat a un profil lié via une relation
    $users = User::where('type', 'candidat')->with('profile')->get();

    return view('ProfilRecruteur', compact('users'));
}

}
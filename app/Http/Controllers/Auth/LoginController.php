<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
     public function dashboard()
    {
        $user = Auth::user();

        if ($user->type === 'candidat') {
            $candidatProfile = $user->profile;  // relation polymorphique
            // Utilise $candidatProfile->prenom, etc.
            return view('dashboard_candidat', compact('candidatProfile'));
        }

        // Pour d'autres types d'utilisateur, traiter ici
        return view('dashboard_general', compact('user'));
    }
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | Ce contrôleur gère l'authentification des utilisateurs pour l'application
    | et les redirige vers l'écran d'accueil après la connexion. Le contrôleur
    | utilise un trait pour inclure cette fonctionnalité.
    |
    */

    use AuthenticatesUsers;

    /**
     * Où rediriger les utilisateurs après connexion.
     *
     * @var string
     */
    protected $redirectTo = '/home';

// Dans app/Http/Controllers/Auth/LoginController.php

    /*protected function redirectTo()
     {
    return '/ProfilCandidat/' . auth()->user()->name; // Assurez-vous que votre modèle User a un champ `username`
     }*/
    protected function redirectTo()
{
    $user = auth()->user();

    if ($user->type === 'candidat') {
        return '/ProfilCandidat/' . $user->name;
    } elseif ($user->type === 'recruteur') {
        return '/ProfilRecruteur';
    }

    return '/home'; // par défaut
}

     
    /**
     * Crée une nouvelle instance du contrôleur.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
    }
}

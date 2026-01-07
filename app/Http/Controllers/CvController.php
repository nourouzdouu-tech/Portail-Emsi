<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cv;

class CvController extends Controller
{
    // Vos méthodes existantes...

    /**
     * Méthode spécifique pour le nouveau formulaire HTML
     */
    public function store(Request $request)
    {
        $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:255',
            'ville' => 'nullable|string|max:255',
            'profil' => 'nullable|string',
            'formations' => 'nullable|array',
            'formations.*.diplome' => 'nullable|string|max:255',
            'formations.*.etablissement' => 'nullable|string|max:255',
            'formations.*.annee_debut' => 'nullable|integer|min:1950|max:2030',
            'formations.*.annee_fin' => 'nullable|integer|min:1950|max:2030',
            'experiences' => 'nullable|array',
            'experiences.*.poste' => 'nullable|string|max:255',
            'experiences.*.entreprise' => 'nullable|string|max:255',
            'experiences.*.date_debut' => 'nullable|date',
            'experiences.*.date_fin' => 'nullable|date',
            'experiences.*.description' => 'nullable|string',
            'competences' => 'nullable|array',
            'competences.*.nom' => 'nullable|string|max:255',
            'competences.*.niveau' => 'nullable|string|in:Débutant,Intermédiaire,Avancé,Expert',
        ]);
       
        $user = Auth::user();
        
        // Préparer les données pour votre format existant
        $experiences_formatted = [];
        if ($request->has('experiences')) {
            foreach ($request->experiences as $exp) {
                if (!empty($exp['poste']) || !empty($exp['entreprise'])) {
                    $experiences_formatted[] = [
                        'title' => $exp['poste'] ?? '',
                        'company' => $exp['entreprise'] ?? '',
                        'start_date' => $exp['date_debut'] ?? '',
                        'end_date' => $exp['date_fin'] ?? '',
                        'description' => $exp['description'] ?? ''
                    ];
                }
            }
        }
        
        // Formater les compétences
        $skills_formatted = [];
        if ($request->has('competences')) {
            foreach ($request->competences as $comp) {
                if (!empty($comp['nom'])) {
                    $skills_formatted[] = $comp['nom'] . ' (' . ($comp['niveau'] ?? 'Non spécifié') . ')';
                }
            }
        }
        
        $cv = Cv::create([
            'user_id' => $user->id,
            'template' => 'default', // Template par défaut
            'first_name' => $request->prenom,
            'last_name' => $request->nom,
            'email' => $request->email,
            'phone' => $request->telephone,
            'job_title' => '', // Pas dans le formulaire actuel
            'profile' => $request->profil,
            'experiences' => json_encode($experiences_formatted),
            'skills' => implode(', ', $skills_formatted),
            'status' => 'completed',
            'name' => $request->prenom . ' ' . $request->nom . ' - CV',
            // Données supplémentaires spécifiques au nouveau formulaire
            'address' => $request->adresse,
            'city' => $request->ville,
            'formations' => json_encode($request->formations ?? []),
        ]);
       
        return redirect()->back()->with('success', 'CV créé avec succès !');
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        return view('cv.create');
    }

    // Vos autres méthodes existantes restent inchangées...
}
<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\Models\Candidature;
use App\Models\OffreEmploi;
use App\Models\User;
use Illuminate\Http\Request;

class OffreEmploiController extends Controller
{
    public function index(Request $request)
    {
        try {
            $recruteurId = (int) $request->query('recruteur');

            $query = OffreEmploi::query();

            if ($recruteurId > 0) {
                $query->where('user_id', $recruteurId);
            }

            $offres = $query->get();

            return response()->json($offres);
        } catch (\Exception $e) {
            \Log::error('Erreur index OffreEmploi: ' . $e->getMessage());
            return response()->json([
                'message' => 'Erreur lors du chargement des offres',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Affichage des offres via l'API (version avec `actif` + candidatures)
    public function indexApi(Request $request)
    {
        $query = OffreEmploi::where('actif', true)
            ->withCount('candidatures')
            ->orderBy('date_publication', 'desc');

        if ($request->boolean('recruteur') && auth()->check()) {
            $query->where('user_id', auth()->id());
        }

        return response()->json($query->get());
    }

    // Création d’une offre d’emploi via l’API
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'entreprise' => 'required|string|max:255',
            'description' => 'required|string',
            'type_contrat' => 'required|string|max:50',
            'lieu' => 'required|string|max:255',
            'region' => 'required|string|max:255',
            'secteur' => 'required|string|max:255',
            'competences' => 'required|array',
            'salaire_min' => 'nullable|numeric',
            'salaire_max' => 'nullable|numeric',
            'experience_requise' => 'required|integer|min:0',
            'url_candidature' => 'nullable|url',
        ]);

        $offre = OffreEmploi::create([
            ...$validated,
            'competences' => json_encode($validated['competences']),
            'user_id' => auth()->id(),
            'date_publication' => now(),
            'date_expiration' => now()->addDays(30),
            'actif' => true,
            'vues' => 0,
            'favoris' => 0,
        ]);

        return response()->json($offre);
    }

    // Affichage d’une offre spécifique
    public function show($id)
    {
        $offre = OffreEmploi::findOrFail($id);
        $offre->incrementerVues();

        $offresAssociees = OffreEmploi::where('actif', true)
            ->where('id', '!=', $id)
            ->where(function ($query) use ($offre) {
                $query->where('secteur', $offre->secteur)
                    ->orWhere('region', $offre->region)
                    ->orWhere('entreprise', $offre->entreprise);
            })
            ->limit(3)
            ->get();

        return view('offres.show', compact('offre', 'offresAssociees'));
    }

    // Recherche en texte libre (autocomplétion)
    public function recherche(Request $request)
    {
        $terme = $request->get('q', '');

        if (strlen($terme) < 2) {
            return response()->json([]);
        }

        $offres = OffreEmploi::where('actif', true)
            ->where(function ($query) use ($terme) {
                $query->where('titre', 'like', "%$terme%")
                    ->orWhere('entreprise', 'like', "%$terme%")
                    ->orWhere('lieu', 'like', "%$terme%");
            })
            ->limit(5)
            ->get(['id', 'titre', 'entreprise', 'lieu'])
            ->map(function ($offre) {
                return [
                    'id' => $offre->id,
                    'text' => $offre->titre . ' - ' . $offre->entreprise . ' (' . $offre->lieu . ')'
                ];
            });

        return response()->json($offres);
    }

    // Page de dashboard pour les recruteurs
    public function dashboard()
    {
        $candidats = User::where('type', 'candidat')->with('profile')->get();
        return view('dashboard', compact('candidats'));
    }

    // Générer des offres par défaut (local only)
    private function getOffresParDefaut()
    {
        $offresData = [
            [
                'titre' => 'Développeur Full Stack PHP/Laravel',
                'entreprise' => 'TechCorp Solutions',
                'description' => 'Nous recherchons un développeur expérimenté en PHP/Laravel...',
                'salaire_min' => 40000,
                'salaire_max' => 55000,
                'type_contrat' => 'CDI',
                'lieu' => 'Paris 15ème',
                'region' => 'Île-de-France',
                'secteur' => 'Informatique / Digital',
                'experience_requise' => 3,
                'competences' => ['PHP', 'Laravel', 'MySQL', 'JavaScript', 'Git'],
                'date_publication' => now()->subDays(2),
                'vues' => 45,
                'favoris' => 12
            ],
        ];

        return collect($offresData)->map(function ($data) {
            return (object) array_merge($data, [
                'id' => rand(1000, 9999),
                'actif' => true,
                'url_candidature' => '#',
                'source' => 'Site officiel',
                'date_expiration' => now()->addDays(30)
            ]);
        });
    }
    public function gestion(Request $request)
{
    $query = OffreEmploi::query();

    // Recherche texte simple
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('titre', 'like', "%$search%")
              ->orWhere('entreprise', 'like', "%$search%")
              ->orWhere('lieu', 'like', "%$search%")
              ->orWhere('secteur', 'like', "%$search%");
        });
    }

    // Optionnel: afficher uniquement les offres actives
    $query->where('actif', 1);

    $offres = $query->orderBy('date_publication', 'desc')->paginate(10);

    return view('GestionOffre', compact('offres'));
}

    public function gestionCand(Request $request)
{
    $query = OffreEmploi::query();

    // Recherche texte simple
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('titre', 'like', "%$search%")
              ->orWhere('entreprise', 'like', "%$search%")
              ->orWhere('lieu', 'like', "%$search%")
              ->orWhere('secteur', 'like', "%$search%");
        });
    }

    // Optionnel: afficher uniquement les offres actives
    $query->where('actif', 1);

    $offres = $query->orderBy('date_publication', 'desc')->paginate(10);

    return view('GestionOffreCand', compact('offres'));
}
 /*public function postuler(Request $request)
{
    $request->validate([
        'offre_id' => 'required|exists:offres_emploi,id',
        'cv' => 'required|file|mimes:pdf|max:2048',
        'lettre' => 'required|file|mimes:pdf|max:2048',
    ]);

    $user = auth()->user();
    if (!$user || $user->type !== 'candidat') {
        return redirect()->back()->with('error', 'Seuls les candidats peuvent postuler à une offre.');
    }

    $cvPath = $request->file('cv')->store('candidatures/cv', 'public');
    $lettrePath = $request->file('lettre')->store('candidatures/lettres', 'public');

    // Ici, on suppose qu'il y a une relation entre OffreEmploi et User via une table de candidatures
    \DB::table('candidatures')->insert([
        'user_id' => $user->id,
        'offre_id' => $request->offre_id,
        'cv' => $cvPath,
        'lettre_motivation' => $lettrePath,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->back()->with('success', 'Votre candidature a été envoyée avec succès.');
}*/
public function storeCandidat(Request $request)
{
    $request->validate([
        'offre_id' => 'required|exists:offres_emploi,id',
        'cv' => 'required|file|mimes:pdf|max:2048',
        'lettre_motivation' => 'required|file|mimes:pdf|max:2048',
    ]);

    $dejaPostule = Candidature::where('user_id', Auth::id())
        ->where('offre_id', $request->offre_id)
        ->exists();

    if ($dejaPostule) {
        return back()->with('error', 'Vous avez déjà postulé à cette offre.');
    }

    $cvPath = $request->file('cv')->store('cvs', 'public');
    $lettrePath = $request->file('lettre_motivation')->store('lettres', 'public');

    Candidature::create([
        'offre_id' => $request->offre_id,
        'user_id' => Auth::id(),
        'cv' => $cvPath,
        'lettre_motivation' => $lettrePath,
    ]);

    return back()->with('success', 'Candidature envoyée avec succès.');
}

}

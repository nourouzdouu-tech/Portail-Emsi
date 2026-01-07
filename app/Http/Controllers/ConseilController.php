<?php
namespace App\Http\Controllers;

use App\Models\Conseil;
use Illuminate\Http\Request;

class ConseilController extends Controller
{
    public function index()
    {
        $conseilsCV = Conseil::actif()
            ->parCategorie('cv')
            ->ordonnes()
            ->get();

        $conseilsLettre = Conseil::actif()
            ->parCategorie('lettre')
            ->ordonnes()
            ->get();

        $conseilsEntretien = Conseil::actif()
            ->parCategorie('entretien')
            ->ordonnes()
            ->get();

        // Données par défaut si la base est vide
        if ($conseilsCV->isEmpty()) {
            $conseilsCV = collect([
                (object)[
                    'titre' => 'Structure et mise en page',
                    'contenu' => [
                        'Utilisez une mise en page claire et aérée',
                        'Maximum 2 pages pour un profil expérimenté',
                        'Police lisible (Arial, Calibri) taille 11-12',
                        'Marges de 2cm minimum'
                    ]
                ],
                (object)[
                    'titre' => 'Informations personnelles',
                    'contenu' => [
                        'Nom, prénom, téléphone, email professionnel',
                        'Adresse (ville suffit)',
                        'Photo professionnelle (optionnelle)',
                        'Liens LinkedIn, portfolio si pertinents'
                    ]
                ],
                (object)[
                    'titre' => 'Expériences professionnelles',
                    'contenu' => [
                        'Ordre chronologique inversé (plus récent en premier)',
                        'Intitulé du poste, entreprise, dates, lieu',
                        'Missions principales et réalisations',
                        'Chiffres et résultats concrets'
                    ]
                ]
            ]);
        }

        if ($conseilsLettre->isEmpty()) {
            $conseilsLettre = collect([
                (object)[
                    'titre' => 'En-tête et présentation',
                    'contenu' => [
                        'Vos coordonnées en haut à droite',
                        'Coordonnées de l\'entreprise à gauche',
                        'Date et lieu',
                        'Objet clair et précis'
                    ]
                ],
                (object)[
                    'titre' => 'Structure du contenu',
                    'contenu' => [
                        'Introduction : pourquoi cette entreprise',
                        'Développement : vos compétences et expériences',
                        'Conclusion : votre motivation et disponibilité',
                        'Formule de politesse'
                    ]
                ],
                (object)[
                    'titre' => 'Style et ton',
                    'contenu' => [
                        'Personnalisez chaque lettre',
                        'Ton professionnel mais pas trop formel',
                        'Évitez les répétitions avec le CV',
                        'Maximum 1 page'
                    ]
                ]
            ]);
        }

        if ($conseilsEntretien->isEmpty()) {
            $conseilsEntretien = collect([
                (object)[
                    'titre' => 'Préparation',
                    'contenu' => [
                        'Recherchez l\'entreprise et le secteur',
                        'Relisez votre CV et la fiche de poste',
                        'Préparez vos questions sur l\'entreprise',
                        'Entraînez-vous aux questions classiques'
                    ]
                ],
                (object)[
                    'titre' => 'Présentation',
                    'contenu' => [
                        'Tenue vestimentaire adaptée',
                        'Arrivez 10 minutes en avance',
                        'Poignée de main ferme et sourire',
                        'Éteignez votre téléphone'
                    ]
                ],
                (object)[
                    'titre' => 'Pendant l\'entretien',
                    'contenu' => [
                        'Maintenez le contact visuel',
                        'Écoutez attentivement les questions',
                        'Donnez des exemples concrets',
                        'Posez des questions pertinentes'
                    ]
                ]
            ]);
        }

        return view('conseils.index', compact('conseilsCV', 'conseilsLettre', 'conseilsEntretien'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|array',
            'categorie' => 'required|in:cv,lettre,entretien',
            'ordre' => 'integer|min:0'
        ]);

        $conseil = Conseil::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Conseil ajouté avec succès',
            'conseil' => $conseil
        ]);
    }
}
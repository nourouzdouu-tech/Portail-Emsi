<?php
// =============================================================================
// MODEL: app/Models/OffreEmploi.php
// =============================================================================

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class OffreEmploi extends Model
{
    use HasFactory;

    protected $table = 'offres_emploi';
    

    protected $fillable = [
    'titre',
    'entreprise',
    'description',
    'type_contrat',
    'lieu',
    'region',
    'secteur',
    'competences',
    'salaire_min',
    'salaire_max',
    'experience_requise',
    'url_candidature',
    'user_id',
    'date_publication',
    'date_expiration',
    'actif',
    'vues',
    'favoris'
];

protected $casts = [
    'competences' => 'array',
    'date_publication' => 'datetime',
    'date_expiration' => 'datetime',
    'salaire_min' => 'float',
    'salaire_max' => 'float',
];


    
   /* protected $fillable = [
        'titre',
        'entreprise',
        'description',
        'salaire_min',
        'salaire_max',
        'type_contrat',
        'lieu',
        'region',
        'secteur',
        'experience_requise',
        'competences',
        'date_publication',
        'date_expiration',
        'url_candidature',
        'source',
        'actif',
        'vues',
        'favoris'
    ];

    protected $casts = [
        'competences' => 'array',
        'date_publication' => 'date',
        'date_expiration' => 'date',
        'actif' => 'boolean',
        'salaire_min' => 'integer',
        'salaire_max' => 'integer',
        'vues' => 'integer',
        'favoris' => 'integer'
    ];*/

    /* Relations
    public function candidatures()
    {
        return $this->hasMany(Candidature::class);
    }*/
    public function candidatures()
    {
        return $this->hasMany(Candidature::class, 'offre_id');
    }


    // Scopes
    public function scopeActif($query)
    {
        return $query->where('actif', true);
    }

    public function scopeRecent($query)
    {
        return $query->where('date_publication', '>=', now()->subDays(30));
    }

    public function scopeParRegion($query, $region)
    {
        return $query->where('region', $region);
    }

    public function scopeParSecteur($query, $secteur)
    {
        return $query->where('secteur', $secteur);
    }

    public function scopeParTypeContrat($query, $type)
    {
        return $query->where('type_contrat', $type);
    }

    public function scopeRechercheTexte($query, $texte)
    {
        return $query->where(function ($q) use ($texte) {
            $q->where('titre', 'like', "%{$texte}%")
              ->orWhere('entreprise', 'like', "%{$texte}%")
              ->orWhere('description', 'like', "%{$texte}%")
              ->orWhere('lieu', 'like', "%{$texte}%");
        });
    }

    public function scopeSalaireMin($query, $min)
    {
        return $query->where('salaire_min', '>=', $min);
    }

    public function scopeExperienceMax($query, $max)
    {
        return $query->where('experience_requise', '<=', $max);
    }

    // Accesseurs
    public function getSalaireFormatteAttribute()
    {
        if ($this->salaire_min && $this->salaire_max) {
            return number_format($this->salaire_min, 0, ',', ' ') . ' - ' . 
                   number_format($this->salaire_max, 0, ',', ' ') . ' €';
        } elseif ($this->salaire_min) {
            return 'À partir de ' . number_format($this->salaire_min, 0, ',', ' ') . ' €';
        }
        return 'Salaire non spécifié';
    }

    public function getExperienceFormatteAttribute()
    {
        if ($this->experience_requise == 0) {
            return 'Débutant accepté';
        } elseif ($this->experience_requise == 1) {
            return '1 an d\'expérience';
        } else {
            return $this->experience_requise . ' ans d\'expérience';
        }
    }

    public function getDatePublicationFormatteAttribute()
    {
        return $this->date_publication->diffForHumans();
    }

    // Méthodes
    public function incrementerVues()
    {
        $this->increment('vues');
    }

    public function estExpire()
    {
        return $this->date_expiration && $this->date_expiration < now();
    }


 /*   // Dans OffreEmploiController.php

public function indexApi(Request $request)
{
    $query = OffreEmploi::actif()
        ->withCount('candidatures')
        ->orderBy('date_publication', 'desc');
    
    // Filtre pour le recruteur connecté
    if ($request->recruteur && auth()->check()) {
        $query->where('user_id', auth()->id());
    }
    
    return response()->json($query->get());
}

public function store(Request $request)
{
    $validated = $request->validate([
        'titre' => 'required|string|max:255',
        'entreprise' => 'required|string|max:255',
        'description' => 'required|string',
        'type_contrat' => 'required|string|in:CDI,CDD,Freelance,Stage,Alternance',
        'lieu' => 'required|string|max:255',
        'region' => 'required|string|max:255',
        'secteur' => 'required|string|max:255',
        'competences' => 'required|array',
        'competences.*' => 'string|max:255',
        'experience_requise' => 'required|integer|min:0',
        'salaire_min' => 'nullable|integer',
        'salaire_max' => 'nullable|integer',
        'url_candidature' => 'nullable|url'
    ]);
    
    $offre = OffreEmploi::create(array_merge(
        $validated,
        [
            'user_id' => auth()->id(),
            'date_publication' => now(),
            'date_expiration' => now()->addDays(30),
            'actif' => true,
            'vues' => 0,
            'favoris' => 0
        ]
    ));
    
    return response()->json($offre, 201);
}*/
}

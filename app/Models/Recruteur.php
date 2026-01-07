<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recruteur extends Model
{
    protected $table = 'recruteurs';

    protected $fillable = [
        'entreprise',
        'secteur',
        'logo',
        'description',
        'site_web',
        'user_id'
    ];

    // Relation avec l'utilisateur (1:1)
  public function user()
{
    return $this->morphOne(User::class, 'profile');
}


    // Relation avec les offres (1:N)
    public function offres()
    {
        return $this->hasMany(Offre::class);
    }

    // Relation avec les candidats via offres (N:N)
    public function candidats()
    {
        return $this->hasManyThrough(
            Candidat::class,
            Offre::class,
            'recruteur_id', // Clé étrangère dans Offre
            'id',          // Clé locale dans Candidat
            'id',          // Clé locale dans Recruteur
            'id'           // Clé étrangère dans Offre
        );
    }
}
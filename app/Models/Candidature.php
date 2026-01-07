<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidature extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'offre_id',
        'cv',
        'lettre_motivation',
    ];

    /**
     * Le candidat qui a postulé.
     */
    public function candidat()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * L'offre d'emploi pour laquelle la candidature a été envoyée.
     */
    public function offre()
    {
        return $this->belongsTo(OffreEmploi::class, 'offre_id');
    }
}

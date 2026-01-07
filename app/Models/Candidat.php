<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidat extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'ville',
        'about',
        'cv_path',
        'lettre_motivation',
        'competences',
        'niveau_etude',
        'annees_experience',
    ];

    protected $casts = [
        'competences' => 'array',
    ];

    public function user()
    {
        return $this->morphOne(User::class, 'profile');
    }
}

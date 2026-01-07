<?php

namespace App\Models;

class Offre extends Model
{
    protected $fillable = [
        'titre', 'description', 'salaire', 'recruteur_id'
    ];

    public function recruteur()
    {
        return $this->belongsTo(Recruteur::class);
    }
}
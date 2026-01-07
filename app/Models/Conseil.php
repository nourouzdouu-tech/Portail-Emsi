<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conseil extends Model
{
    use HasFactory;

    protected $table = 'conseils';
    
    protected $fillable = [
        'titre',
        'contenu',
        'categorie',
        'ordre',
        'actif'
    ];

    protected $casts = [
        'actif' => 'boolean',
        'contenu' => 'array'
    ];

    // Scopes
    public function scopeActif($query)
    {
        return $query->where('actif', true);
    }

    public function scopeParCategorie($query, $categorie)
    {
        return $query->where('categorie', $categorie);
    }

    public function scopeOrdonnes($query)
    {
        return $query->orderBy('ordre', 'asc');
    }
}

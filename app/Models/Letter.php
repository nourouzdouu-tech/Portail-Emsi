<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lettre extends Model
{
    use HasFactory;

    protected $fillable = [
        'prenom',
        'nom',
        'adresse',
        'telephone',
        'email',
        'entreprise',
        'adresseEntreprise',
        'poste',
        'objet',
        'introduction',
        'competences',
        'motivation',
        'conclusion'
    ];
}

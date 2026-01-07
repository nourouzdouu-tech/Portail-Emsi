<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Candidat;

class CandidatSeeder extends Seeder
{
    public function run(): void
    {
        Candidat::create([
            'name' => 'Kenza',
            'phone' => '0612345678',
            'ville' => 'Casablanca',
            'about' => 'Développeuse passionnée avec un fort intérêt pour le développement web et l’apprentissage continu.',
            'cv_path' => 'cvs/kenza_cv.pdf',
            'lettre_motivation' => 'Je suis motivée à rejoindre une entreprise innovante où je pourrai mettre en pratique mes compétences et apprendre davantage.',
            'competences' => ['Laravel', 'PHP', 'HTML', 'CSS', 'JavaScript'],
            'niveau_etude' => 'Bac+3',
            'annees_experience' => 2,
        ]);
    }
}

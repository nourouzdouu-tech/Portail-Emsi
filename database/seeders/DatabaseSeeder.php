<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Candidat;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CandidatSeeder::class,
        ]);

        // Admin
        User::updateOrCreate(
            ['email' => 'kenza@gmail.com'],
            [
                'name' => 'Kenza',
                'password' => Hash::make('motdepasse123'),
                'type' => 'admin',
            ]
        );

        // Recruteur
        User::updateOrCreate(
            ['email' => 'nour@gmail.com'],
            [
                'name' => 'Nour',
                'password' => Hash::make('nour123'),
                'type' => 'recruteur',
            ]
        );

        // Candidat Aya
        $candidatAya = Candidat::create([
            'name' => 'Aya',
            'phone' => '0600000000',
            'ville' => 'Casablanca',
            'about' => 'Développeuse passionnée',
            'cv_path' => 'cv_aya.pdf',
            'lettre_motivation' => 'Je suis très motivée...',
            'competences' => ['Laravel', 'PHP', 'MySQL'],
            'niveau_etude' => 'Licence',
            'annees_experience' => 2,
        ]);

        $aya = User::updateOrCreate(
            ['email' => 'aya@gmail.com'],
            [
                'name' => 'Aya',
                'password' => Hash::make('aya123'),
                'type' => 'candidat',
            ]
        );

        $aya->profile()->associate($candidatAya);
        $aya->save();

        // Candidat Marwa
        $candidatMarwa = Candidat::create([
            'name' => 'Marwa',
            'phone' => '0600000000',
            'ville' => 'Casablanca',
            'about' => 'Développeuse passionnée',
            'cv_path' => null,
            'lettre_motivation' => null,
            'competences' => ['Laravel', 'JS'],
            'niveau_etude' => 'Bac+5',
            'annees_experience' => 2,
        ]);

        $userMarwa = User::create([
            'name' => 'Marwa',
            'email' => 'marwa@gmail.com',
            'password' => Hash::make('123456'),
            'type' => 'candidat',
            'profile_id' => $candidatMarwa->id,
            'profile_type' => Candidat::class,
        ]);
    }
}

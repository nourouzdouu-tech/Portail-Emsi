<?php

// app/Http/Controllers/EntrepriseController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EntrepriseController extends Controller
{
    public function index()
    {
        $entreprises = [
            (object)[
                'nom' => 'Inwi',
                'secteur' => 'Télécommunications',
                'ville' => 'Casablanca',
                'pays' => 'Maroc',
                'email' => 'contact@inwi.ma'
            ],
            (object)[
                'nom' => 'OCP Group',
                'secteur' => 'Industrie minière',
                'ville' => 'Khouribga',
                'pays' => 'Maroc',
                'email' => 'contact@ocpgroup.ma'
            ],
            (object)[
                'nom' => 'Attijariwafa Bank',
                'secteur' => 'Banque',
                'ville' => 'Casablanca',
                'pays' => 'Maroc',
                'email' => 'contact@attijariwafa.ma'
            ],
             (object)[
                'nom' => 'Sqli',
                'secteur' => 'IT',
                'ville' => 'Casablanca,Rabat',
                'pays' => 'Maroc',
                'email' => 'contact@Sqli.ma'
            ],
             (object)[
                'nom' => 'XHub',
                'secteur' => 'Développement Web & Mobile',
                'ville' => 'Casablanca',
                'pays' => 'Maroc',
                'email' => 'contact@XHub.ma'
            ],
            
        ];

        return view('entreprises', compact('entreprises'));
    }
}

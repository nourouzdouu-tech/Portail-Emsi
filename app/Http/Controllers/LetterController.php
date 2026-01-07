<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;

class LetterController extends Controller
{
    // Affiche le formulaire
    public function index()
{
    return view('Lettre.lettreMotiv'); // Correspond au fichier resources/views/Lettre/lettreMotiv.blade.php
}


    // Génère une lettre de motivation en fonction des champs soumis (ex : pour affichage ou PDF)
    public function generer(Request $request)
    {
        $data = $request->all();

        // Optionnel : Générer un PDF
        // $pdf = \PDF::loadView('lettre.modele', $data);
        // return $pdf->download('lettre_de_motivation.pdf');

        return view('lettre.modele', compact('data'));
    }

    // Sauvegarde des données dans un fichier ou la base de données
    public function sauvegarder(Request $request)
    {
        $data = $request->only([
            'prenom', 'nom', 'adresse', 'telephone', 'email',
            'entreprise', 'adresseEntreprise', 'poste',
            'objet', 'introduction', 'competences', 'motivation', 'conclusion'
        ]);

        // Exemple : Sauvegarde dans un fichier JSON
        Storage::put('lettres/lettre_' . time() . '.json', json_encode($data, JSON_PRETTY_PRINT));

        return redirect()->back()->with('success', 'Lettre sauvegardée avec succès.');

    Lettre::create($request->all());

    return redirect()->back()->with('success', 'Lettre sauvegardée dans la base de données avec succès.');
    }

}


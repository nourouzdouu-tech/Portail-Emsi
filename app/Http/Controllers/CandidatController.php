<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Models\Offre;
use Illuminate\Http\Request;

class CandidatController extends Controller
{
    public function postuler(Request $request, $offreId)
    {
        $offre = Offre::findOrFail($offreId);
        auth()->user()->profile->offres()->attach($offreId, [
            'cv_path' => $request->file('cv')->store('cvs')
        ]);

        return back()->with('success', 'Candidature envoyée!');
    }
}
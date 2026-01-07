<?php

namespace App\Http\Controllers;

use App\Models\Offre;
use Illuminate\Http\Request;

class OffreController extends Controller
{
   public function index(Request $request)
    {
        try {
            $user = (int) $request->query('candidat');

            $query = OffreEmploi::query();

            if ($user > 0) {
                $query->where('user_id', $user);
            }

            $offres = $query->get();

            return response()->json($offres);
        } catch (\Exception $e) {
            \Log::error('Erreur index OffreEmploi: ' . $e->getMessage());
            return response()->json([
                'message' => 'Erreur lors du chargement des offres',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
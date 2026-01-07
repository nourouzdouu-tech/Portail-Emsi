<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Service;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Affiche la page de présentation de la société
     */
    public function index()
    {
        $company = Company::first();
        $services = Service::where('is_active', true)->take(6)->get();
        $teamMembers = TeamMember::where('is_active', true)->take(4)->get();
        
        return view('company.presentation', compact('company', 'services', 'teamMembers'));
    }

    /**
     * Affiche les détails d'un service
     */
    public function showService($id)
    {
        $service = Service::findOrFail($id);
        return response()->json($service);
    }

    /**
     * Traite le formulaire de contact
     */
    public function contact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ]);

        // Ici vous pouvez ajouter la logique pour envoyer l'email
        // Mail::to('contact@blade.com')->send(new ContactMail($request->all()));

        return response()->json([
            'success' => true,
            'message' => 'Votre message a été envoyé avec succès!'
        ]);
    }
}
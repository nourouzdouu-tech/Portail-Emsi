<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();  // récupère l'utilisateur connecté
        return view('home', compact('user'));
    }
}

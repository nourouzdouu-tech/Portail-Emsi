<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecruteurController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\CvController;
use App\Http\Controllers\LetterController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\ConseilController;
use App\Http\Controllers\OffreEmploiController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EntrepriseController;



Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('home');  // connecté => dashboard
    }
    return redirect()->route('login');    // non connecté => login
});

Route::get('/home', [HomeController::class, 'index'])
    ->name('home')
    ->middleware('auth');

// use App\Http\Controllers\OffreController; // Décommente seulement quand il existe
// use App\Http\Controllers\RecruteurController; // Idem
// use App\Http\Controllers\CandidatController;

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Authentification
|--------------------------------------------------------------------------
*/
Auth::routes();


Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/ProfilCandidat/{name}', [ProfileController::class, 'show'])->name('ProfilCandidat.candidat');

Route::get('/ProfilRecruteur', function () {
    return view('ProfilRecruteur');
})->middleware('auth');



Route::get('/entreprises', [EntrepriseController::class, 'index'])->middleware('auth');


//Route::get('/ProfilRecruteur/{name}', [RecruteurController::class, 'show'])->name('ProfilRecruteur.recruteur');

Route::get('/login2', [RecruteurController::class, 'showLoginForm'])->name('login2');
Route::post('/login2', [RecruteurController::class, 'login2']);


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/ProfilCandidat', [ProfileController::class, 'index'])->name('ProfilCandidat.candidat');

Route::get('/ProfilCandidat', [ProfileController::class, 'edit'])->name('ProfilCandidat.edit');

Route::post('/ProfilCandidat', [ProfileController::class, 'update'])->name('ProfilCandidat.update');

//Route::middleware(['auth'])->group(function () {
  //  Route::get('/profileCandidat', [ProfileController::class, 'edit'])->name('profile.edit');
    //Route::post('/profileCandidat', [ProfileController::class, 'update'])->name('profile.update');
//});

Route::middleware(['auth'])->get('/dashboard', [ProfileController::class, 'dashboard'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Routes pour les recruteurs (protéger avec middlewares personnalisés)
|--------------------------------------------------------------------------
*/
Route::prefix('recruteur')->middleware(['auth', 'recruteur'])->group(function () {
    // Exemple de routes (à décommenter quand les contrôleurs sont créés)

    // Route::get('/dashboard', [RecruteurController::class, 'dashboard'])->name('recruteur.dashboard');
    // Route::post('/offres', [RecruteurController::class, 'storeOffre'])->name('recruteur.offres.store');
    // Route::get('/offres/{id}/candidatures', [RecruteurController::class, 'candidatures'])->name('recruteur.candidatures');
});

/*
|--------------------------------------------------------------------------
| Routes pour les offres (à activer quand OffreController est créé)
|--------------------------------------------------------------------------
*/
// Route::resource('offres', OffreController::class)->middleware('auth');

/*
|--------------------------------------------------------------------------
| Routes pour les candidatures (à activer quand CandidatController est créé)
|--------------------------------------------------------------------------
*/
// Route::post('offres/{offre}/postuler', [CandidatController::class, 'postuler'])
//     ->name('candidatures.store')
//     ->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/documents', [DocumentController::class, 'index']);
});

// CV & LETTERS

Route::post('/cv/store', [CvController::class, 'store'])->name('cv.store');
Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
Route::post('/documents/upload', [DocumentController::class, 'upload'])->name('documents.upload');
Route::post('/letters/store', [LetterController::class, 'store'])->name('letters.store');
Route::get('/documents/{id}/preview', [DocumentController::class, 'preview']);
Route::get('/documents/{id}/edit', [DocumentController::class, 'edit']);
Route::post('/documents/{id}/update', [DocumentController::class, 'update']);
Route::delete('/documents/{id}', [DocumentController::class, 'destroy']);
Route::get('/documents/{id}/download', [DocumentController::class, 'download']);
Route::get('/CVLettre', function () {
    return view('CVLettre');
});



Route::middleware('auth')->group(function () {
    Route::get('/edit-profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/edit-profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/ProfilCandidat', [ProfileController::class, 'index'])->name('ProfilCandidat.candidat');

    Route::get('/profil', [ProfileController::class, 'index'])->name('profile.index');
   // Route::get('/profile/{name}', [ProfileController::class, 'show'])->name('profile.show'); // Voir profil par nom

});

// Nouvelle route pour le formulaire HTML
Route::get('/cv/create', [CvController::class, 'create'])->name('cv.create');
Route::post('/cv/form', [CvController::class, 'storeFromForm'])->name('cv.store.form');

// Vos routes API existantes restent inchangées
Route::post('/cv', [CvController::class, 'store'])->name('cv.store');


Route::prefix('Lettre')->name('Lettre.')->group(function () {
    // GET Lettre/lettreMotiv -> LetterController@index
    Route::get('/lettreMotiv', [LetterController::class, 'index'])->name('lettreMotiv');

    // POST generer-lettre -> LetterController@generer
    Route::post('/generer-lettre', [LetterController::class, 'generer'])->name('generer');

    // POST sauvegarder -> LetterController@sauvegarder
    Route::post('/sauvegarder', [LetterController::class, 'sauvegarder'])->name('sauvegarder');
});



Route::middleware(['auth'])->group(function () {
    // Page principale
    Route::get('/RéseauSocial', [SocialController::class, 'index'])->name('social.index');
    
    // Gestion des groupes
    Route::post('/groups', [SocialController::class, 'createGroup'])->name('groups.create');
    Route::delete('/groups/{id}', [SocialController::class, 'deleteGroup'])->name('groups.delete');
    
    // Gestion des médias
    Route::post('/media', [SocialController::class, 'uploadMedia'])->name('media.upload');
    Route::delete('/media/{id}', [SocialController::class, 'deleteMedia'])->name('media.delete');
    
    // Gestion des amis
    Route::get('/friends/search', [SocialController::class, 'searchFriends'])->name('friends.search');
    Route::post('/friends/request', [SocialController::class, 'sendFriendRequest'])->name('friends.request');
    Route::post('/friends/respond/{id}', [SocialController::class, 'respondToRequest'])->name('friends.respond');
    Route::delete('/friends/{id}', [SocialController::class, 'removeFriend'])->name('friends.remove');



Route::post('/messages/send/{friend}', [SocialController::class, 'sendMessage'])->name('messages.send');
Route::get('/messages/{friend}', [SocialController::class, 'getMessages'])->name('messages.get');
});

Route::middleware(['auth'])->group(function () {
    // Posts
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    
    // Autres routes existantes...
});

Route::get('/conseils', [ConseilController::class, 'index'])->name('conseils.index');
Route::post('/conseils', [ConseilController::class, 'store'])->name('conseils.store');



Route::post('/offres', [OffreEmploiController::class, 'store'])->name('offres.store');
Route::get('/offres/count', [OffreEmploiController::class, 'count'])->name('offres.count');


Route::prefix('emploi')->group(function () {
    Route::get('/offres', [App\Http\Controllers\OffreEmploiController::class, 'index'])
        ->name('offres.index');
    
    Route::get('/offres/{id}', [App\Http\Controllers\OffreEmploiController::class, 'show'])
        ->name('offres.show');
    
    Route::get('/api/recherche', [App\Http\Controllers\OffreEmploiController::class, 'recherche'])
        ->name('offres.recherche');
});




Route::middleware(['auth'])->group(function () {
    // Page principale
    Route::get('/RéseauSocialRecrut', [SocialController::class, 'indexRecrut'])->name('social.indexRecrut');
    
    // Gestion des groupes
    Route::post('/groups', [SocialController::class, 'createGroup'])->name('groups.create');
    Route::delete('/groups/{id}', [SocialController::class, 'deleteGroup'])->name('groups.delete');
    
    // Gestion des médias
    Route::post('/media', [SocialController::class, 'uploadMedia'])->name('media.upload');
    Route::delete('/media/{id}', [SocialController::class, 'deleteMedia'])->name('media.delete');
    
    // Gestion des amis
    Route::get('/friends/search', [SocialController::class, 'searchFriends'])->name('friends.search');
    Route::post('/friends/request', [SocialController::class, 'sendFriendRequest'])->name('friends.request');
    Route::post('/friends/respond/{id}', [SocialController::class, 'respondToRequest'])->name('friends.respond');
    Route::delete('/friends/{id}', [SocialController::class, 'removeFriend'])->name('friends.remove');



Route::post('/messages/send/{friend}', [SocialController::class, 'sendMessage'])->name('messages.send');
Route::get('/messages/{friend}', [SocialController::class, 'getMessages'])->name('messages.get');
});

Route::middleware(['auth'])->group(function () {
    // Posts
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    
    // Autres routes existantes...
});

// Page d’accueil des offres (version web, avec filtres si besoin)
Route::get('/offres', [OffreEmploiController::class, 'index'])->name('offres.index');

// Détail d’une offre
Route::get('/offres/{id}', [OffreEmploiController::class, 'show'])->name('offres.show');

// Recherche d’offres (autocomplétion ou filtre rapide)
Route::get('/recherche-offres', [OffreEmploiController::class, 'recherche'])->name('offres.recherche');

// Dashboard recruteur (protégé si nécessaire)
Route::middleware('auth')->get('/dashboard', [OffreEmploiController::class, 'dashboard'])->name('dashboard');

Route::middleware('auth')->post('/offres-emploi', [OffreEmploiController::class, 'store']);

Route::get('/offres-emploi', [OffreEmploiController::class, 'index']);
Route::post('/offres-emploi', [OffreEmploiController::class, 'store']);





Route::get('/presentation', [App\Http\Controllers\CompanyController::class, 'index'])->name('company.index');
Route::get('/company/service/{id}', [App\Http\Controllers\CompanyController::class, 'showService'])->name('company.service');
Route::post('/company/contact', [App\Http\Controllers\CompanyController::class, 'contact'])->name('company.contact');


Route::get('/ProfilRecruteur', [RecruteurController::class, 'showProfilRecruteur'])->middleware('auth');


Route::get('/GestionOffre', [OffreEmploiController::class, 'gestion'])->name('gestion.offres');

//Route::middleware('auth')->group(function () {
    //Route::get('/offres/{id}/postuler', [OffreEmploiController::class, 'showFormPostuler'])->name('offres.form_postuler');
  //  Route::post('/offres/{id}/postuler', [OffreEmploiController::class, 'postuler'])->name('offres.postuler');
//});


/*Route::get('GestionOffreCand', [OffreEmploiController::class, 'postuler'])->name('offres.postuler');

Route::post('GestionOffreCand', [OffreEmploiController::class, 'postuler'])->name('offres.postuler');
Route::get('/GestionOffreCand', [OffreEmploiController::class, 'afficherFormulaire'])->name('gestionoffrecand.form');
*/
Route::get('/GestionOffreCand', [OffreEmploiController::class, 'gestionCand'])->name('gestionCand.offres');

//Route::post('/GestionOffreCand', [OffreEmploiController::class, 'postuler'])->name('offres.postuler');

Route::post('/candidature', [OffreEmploiController::class, 'storeCandidat'])->name('candidature.storeCandidat');





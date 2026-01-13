<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

// Routes d'authentification
Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

// Routes pour l'inscription d'administrateur (limitée à un accès initial)
Route::get('/admin/register', [App\Http\Controllers\AuthController::class, 'showAdminRegisterForm'])->name('admin.register.form');
Route::post('/admin/register', [App\Http\Controllers\AuthController::class, 'adminRegister'])->middleware('allow.admin.registration');

Route::get('/', function () {
    return redirect()->route('dashboard');
})->middleware('auth');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// Routes pour les demandes de messe
Route::get('/demandes', [App\Http\Controllers\DemandeMesseController::class, 'index'])->name('demandes.index')->middleware('auth');
Route::post('/demandes', [App\Http\Controllers\DemandeMesseController::class, 'store'])->name('demandes.store')->middleware('auth');
Route::delete('/demandes/{id}', [App\Http\Controllers\DemandeMesseController::class, 'destroy'])->name('demandes.destroy')->middleware('auth');
Route::get('/demandes/{id}/recu', [App\Http\Controllers\DemandeMesseController::class, 'recu'])->name('demandes.recu')->middleware('auth');
Route::get('/demandes/{id}', function($id) {
    $demande = App\Models\DemandeMesse::findOrFail($id);
    return view('demandes.show', compact('demande'));
})->name('demandes.show')->middleware('auth');

// Routes pour les recettes
Route::get('/recettes', [App\Http\Controllers\RecetteController::class, 'index'])->name('recettes.index')->middleware('auth');
Route::post('/recettes', [App\Http\Controllers\RecetteController::class, 'store'])->name('recettes.store')->middleware('auth');
Route::delete('/recettes/{id}', [App\Http\Controllers\RecetteController::class, 'destroy'])->name('recettes.destroy')->middleware('auth');

// Routes pour les dépenses
Route::get('/depenses', [App\Http\Controllers\DepenseController::class, 'index'])->name('depenses.index')->middleware('auth');
Route::post('/depenses', [App\Http\Controllers\DepenseController::class, 'store'])->name('depenses.store')->middleware('auth');
Route::delete('/depenses/{id}', [App\Http\Controllers\DepenseController::class, 'destroy'])->name('depenses.destroy')->middleware('auth');

// Routes pour les rapports
Route::get('/rapports', function() {
    return view('rapports.index');
})->name('rapports.index')->middleware('auth');

Route::get('/rapports/intentions', [App\Http\Controllers\RapportController::class, 'intentions'])->name('rapports.intentions')->middleware('auth');
Route::get('/rapports/caisse', [App\Http\Controllers\RapportController::class, 'caisse'])->name('rapports.caisse')->middleware('auth');

// Routes pour la gestion des utilisateurs (réservées à l'administrateur)
Route::resource('users', App\Http\Controllers\UserController::class)->middleware(['auth', 'role:admin']);

// Routes pour le profil utilisateur
Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit')->middleware('auth');
Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update')->middleware('auth');

// Routes pour le secrétaire
Route::prefix('secretaire')->middleware(['auth', 'role:secretaire,admin'])->group(function () {
    Route::get('/', [App\Http\Controllers\SecretaireController::class, 'index'])->name('secretaire.index');
    Route::get('/demandes', [App\Http\Controllers\SecretaireController::class, 'demandes'])->name('secretaire.demandes');
    Route::post('/demandes', [App\Http\Controllers\SecretaireController::class, 'storeDemande'])->name('secretaire.store-demande');
    Route::get('/recettes', [App\Http\Controllers\SecretaireController::class, 'recettes'])->name('secretaire.recettes');
    Route::post('/recettes', [App\Http\Controllers\SecretaireController::class, 'storeRecette'])->name('secretaire.store-recette');
    Route::get('/depenses', [App\Http\Controllers\SecretaireController::class, 'depenses'])->name('secretaire.depenses');
    Route::post('/depenses', [App\Http\Controllers\SecretaireController::class, 'storeDepense'])->name('secretaire.store-depense');
    Route::get('/rapports/intentions', [App\Http\Controllers\SecretaireController::class, 'rapportsIntentions'])->name('secretaire.rapports.intentions');
});

// Routes pour le comptable
Route::prefix('comptable')->middleware(['auth', 'role:comptable,admin'])->group(function () {
    Route::get('/', [App\Http\Controllers\ComptableController::class, 'index'])->name('comptable.index');
    Route::get('/recettes', [App\Http\Controllers\ComptableController::class, 'recettes'])->name('comptable.recettes');
    Route::post('/recettes', [App\Http\Controllers\ComptableController::class, 'storeRecette'])->name('comptable.store-recette');
    Route::get('/depenses', [App\Http\Controllers\ComptableController::class, 'depenses'])->name('comptable.depenses');
    Route::post('/depenses', [App\Http\Controllers\ComptableController::class, 'storeDepense'])->name('comptable.store-depense');
    Route::get('/rapports/caisse', [App\Http\Controllers\ComptableController::class, 'rapportsCaisse'])->name('comptable.rapports.caisse');
    Route::get('/suivi-paiements', [App\Http\Controllers\ComptableController::class, 'suivrePaiements'])->name('comptable.suivi-paiements');
});

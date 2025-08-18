<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CotisationController;
use App\Http\Controllers\Admin\UserController;

/*
|--------------------------------------------------------------------------
| Routes Web
|--------------------------------------------------------------------------
*/

// 🏠 Page d'accueil publique
Route::get('/', function () {
    return view('welcome');
})->name('home');

// 🔑 Authentification (visiteurs uniquement)
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

// 📊 Dashboard (uniquement si connecté)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 👤 Gestion du profil (utilisateurs connectés + email vérifié)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Routes protégées par rôle
|--------------------------------------------------------------------------
*/

// 🛡️ Admin : gestion des rôles et des utilisateurs
Route::middleware(['auth', 'checkRole:Admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard'); // crée une vue admin/dashboard.blade.php
    })->name('admin.dashboard');

    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::patch('/admin/users/{user}/role', [UserController::class, 'updateRole'])->name('admin.users.updateRole');
});

// 💰 Trésorier
// 💰 Routes pour Trésorier et Admin
Route::middleware(['auth', 'checkRole:Trésorier'])->group(function () {

    // Toutes les actions sur les cotisations
    Route::resource('cotisations', CotisationController::class);

    // Dashboard spécifique Trésorier (accessible aussi à l'Admin grâce à la hiérarchie)
    Route::get('/tresorier', function () {
        return view('tresorier.dashboard');
    })->name('tresorier.dashboard');
});

// Route pour accéder à ses propres cotisations
Route::middleware(['auth'])->group(function () {
    Route::get('/mes-cotisations', [CotisationController::class, 'mesCotisations'])
        ->name('cotisations.mescotisations');
});

// 📚 Responsable pédagogique
Route::middleware(['auth', 'checkRole:Responsable pédagogique'])->group(function () {
    Route::get('/resp-pedagogique', function () {
        return view('resp.dashboard'); // crée une vue resp/dashboard.blade.php
    })->name('resp.dashboard');
});

// 👥 Membre simple
Route::middleware(['auth', 'checkRole:Membre'])->group(function () {
    Route::get('/membre', function () {
        return view('membre.dashboard'); // crée une vue membre/dashboard.blade.php
    })->name('membre.dashboard');
});

// Formulaire de modification pour le membre connecté
Route::middleware(['auth'])->group(function () {
    Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
});

// ⚠️ Breeze gère déjà l’auth → pas besoin de Auth::routes()
require __DIR__.'/auth.php';

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CotisationController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EmpruntController;

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

    // Formulaire de modification pour le membre connecté
    Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
});

/*
|--------------------------------------------------------------------------
| Routes protégées par rôle
|--------------------------------------------------------------------------
*/

// 🛡️ Admin : gestion des rôles et des utilisateurs
Route::middleware(['auth', 'checkRole:Admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::patch('/admin/users/{user}/role', [UserController::class, 'updateRole'])->name('admin.users.updateRole');
});

// 💰 Trésorier
Route::middleware(['auth', 'checkRole:Trésorier'])->group(function () {
    // Toutes les actions sur les cotisations
    Route::resource('cotisations', CotisationController::class);

    // Dashboard spécifique Trésorier
    Route::get('/tresorier', function () {
        return view('tresorier.dashboard');
    })->name('tresorier.dashboard');
});

// 📚 Responsable pédagogique
Route::middleware(['auth', 'checkRole:Responsable pédagogique'])->group(function () {
    Route::get('/resp-pedagogique', function () {
        return view('resp.dashboard');
    })->name('resp.dashboard');
});

// 👥 Membre simple
Route::middleware(['auth', 'checkRole:Membre'])->group(function () {
    Route::get('/membre', function () {
        return view('membre.dashboard');
    })->name('membre.dashboard');
});

/*
|--------------------------------------------------------------------------
| Routes pour les ressources et emprunts
|--------------------------------------------------------------------------
*/

// Route publique pour lire un document
Route::get('/documents/{document}', [DocumentController::class, 'show'])->name('documents.show');

// Routes authentifiées pour la gestion des ressources et emprunts
Route::middleware(['auth'])->group(function () {
    // ✅ Tous les utilisateurs connectés peuvent voir la liste des ressources
    Route::get('gestion/ressources', [DocumentController::class, 'index'])
        ->name('gestion.ressources');

    // ✅ Route documents.index pour tous les utilisateurs authentifiés
    Route::get('documents', [DocumentController::class, 'index'])
        ->name('documents.index');

    // ✅ Tous les utilisateurs connectés peuvent voir les emprunts
    Route::get('emprunts', [EmpruntController::class, 'index'])
        ->name('emprunts.index');

    // ✅ Mes cotisations
    Route::get('/mes-cotisations', [CotisationController::class, 'mesCotisations'])
        ->name('cotisations.mescotisations');

    // ✅ Mes emprunts
    Route::get('mesemprunts', [EmpruntController::class, 'mesEmprunts'])
        ->name('emprunts.mesemprunts');

    // ✅ Créer un emprunt (tous les rôles authentifiés)
    Route::post('emprunts', [EmpruntController::class, 'store'])
        ->name('emprunts.store');

    // 🔒 Gestion des documents (seulement Admin + Responsable pédagogique)
    Route::middleware(['checkRole:Admin,Responsable pédagogique'])->group(function () {
        // Routes de gestion complète des documents (sauf index et show qui sont déjà définis)
        Route::get('documents/create', [DocumentController::class, 'create'])->name('documents.create');
        Route::post('documents', [DocumentController::class, 'store'])->name('documents.store');
        Route::get('documents/{document}/edit', [DocumentController::class, 'edit'])->name('documents.edit');
        Route::put('documents/{document}', [DocumentController::class, 'update'])->name('documents.update');
        Route::delete('documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');

        // Routes de gestion des emprunts (sauf index et store qui sont déjà définis)
        Route::get('emprunts/create', [EmpruntController::class, 'create'])->name('emprunts.create');
        Route::get('emprunts/{emprunt}', [EmpruntController::class, 'show'])->name('emprunts.show');
        Route::get('emprunts/{emprunt}/edit', [EmpruntController::class, 'edit'])->name('emprunts.edit');
        Route::put('emprunts/{emprunt}', [EmpruntController::class, 'update'])->name('emprunts.update');
        Route::delete('emprunts/{emprunt}', [EmpruntController::class, 'destroy'])->name('emprunts.destroy');
    });
});

// ⚠️ Breeze gère déjà l'auth
require __DIR__.'/auth.php';

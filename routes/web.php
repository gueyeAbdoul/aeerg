<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CotisationController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes Web
|--------------------------------------------------------------------------
*/

// Page principale pour tous les visiteurs
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Inscription (guest uniquement)
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

// Dashboard (authentifié seulement)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Profile (auth + email vérifié)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ⚡ Gestion des cotisations (Trésorier)
Route::middleware(['auth', 'checkRole:Trésorier'])->group(function () {
    Route::resource('cotisations', CotisationController::class);
    Route::get('/tresorier', function () {
        return 'Page Trésorier';
    });
});

// ⚡ Responsable pédagogique
Route::middleware(['auth', 'checkRole:Responsable pédagogique'])->group(function () {
    Route::get('/resp-pedagogique', function () {
        return 'Page Responsable pédagogique';
    });
});

// ⚡ Membre
Route::middleware(['auth', 'checkRole:Membre'])->group(function () {
    Route::get('/membre', function () {
        return 'Page Membre';
    });
});

// ⚡ Admin (gestion des utilisateurs et rôles)
Route::middleware(['auth', 'checkRole:Admin'])->group(function () {
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::patch('/admin/users/{user}/role', [UserController::class, 'updateRole'])->name('admin.users.updateRole');

    Route::get('/admin', function () {
        return 'Page Admin';
    });
});

// ⚠️ Auth routes fournies par Breeze
require __DIR__.'/auth.php';

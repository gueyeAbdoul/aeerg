<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Affiche la vue de connexion.
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Gère la tentative de connexion.
     */
    public function store(Request $request)
    {
        // Validation des champs du formulaire
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Tentative d’authentification
        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            $request->session()->regenerate();

            // ✅ Redirection vers la page principale (welcome.blade.php)
            return redirect()->route('home');
        }

        // Si la connexion échoue
        return back()->withErrors([
            'email' => 'Les informations d’identification ne correspondent pas.',
        ])->onlyInput('email');
    }

    /**
     * Déconnexion de l’utilisateur.
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // ✅ Après déconnexion, on retourne à la page principale
        return redirect()->route('home');
    }
}

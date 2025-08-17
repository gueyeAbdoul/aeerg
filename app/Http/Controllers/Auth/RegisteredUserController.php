<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'telephone' => 'nullable|string|max:20',
            'statut' => 'required|string|in:Étudiant,Élève,Professionnel',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'statut' => $request->statut,
            'password' => Hash::make($request->password),
            'role_id' => 3, // Membre par défaut
        ]);

        event(new Registered($user));

        auth()->login($user);

        return redirect()->route('home')->with('success', 'Inscription réussie ! Bienvenue.');
    }
}

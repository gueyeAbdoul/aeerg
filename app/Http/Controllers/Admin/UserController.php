<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        // Récupère tous les utilisateurs avec leur rôle
        $users = User::with('role')->get();

        // Récupère tous les rôles disponibles (une seule fois)
        $roles = Role::orderBy('nom')->get()->unique('nom'); // Double sécurité

        return view('admin.users.index', compact('users', 'roles'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        $user->role_id = $request->role_id;
        $user->save();

        return redirect()->route('admin.users.index')
                         ->with('success', 'Rôle mis à jour avec succès !');
    }

    public function editProfile()
    {
        $user = Auth::user();
        return view('admin.users.edit', compact('user')); // <-- chemin correct
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'telephone' => 'nullable|string|max:20',
            'statut' => 'required|string',
            'valide' => 'required|boolean',
        ]);

        $user->update($request->only('nom', 'prenom', 'email', 'telephone', 'statut', 'valide'));

        return redirect()->route('profile.edit')->with('success', 'Profil mis à jour avec succès.');
    }

}

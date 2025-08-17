<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

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
}

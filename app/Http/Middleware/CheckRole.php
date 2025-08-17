<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    protected $roleHierarchy = [
        'Admin' => ['Admin', 'Trésorier', 'Responsable pédagogique', 'Membre'],
        'Trésorier' => ['Trésorier', 'Membre'],
        'Responsable pédagogique' => ['Responsable pédagogique', 'Membre'],
        'Membre' => ['Membre'],
    ];

    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();

        // Routes publiques accessibles par tous
        if (!$user) {
            if ($request->routeIs('home') || $request->is('login') || $request->is('register')) {
                return $next($request);
            }
            return redirect()->route('home')->with('error', 'Vous devez vous connecter');
        }

        $userRole = $user->role?->nom;

        // Connecté mais sans rôle
        if (!$userRole) {
            return redirect()->route('home')->with('error', 'Rôle manquant');
        }

        $allowedRoles = $this->roleHierarchy[$userRole] ?? [];

        // Admin passe toujours
        if ($userRole === 'Admin') {
            return $next($request);
        }

        // Vérifie les rôles autorisés
        foreach ($roles as $role) {
            if (in_array($role, $allowedRoles, true)) {
                return $next($request);
            }
        }

        // Accès non autorisé
        return redirect()->route('home')->with('error', 'Accès non autorisé');
    }
}

<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'telephone',
        'statut',
        'role_id',
        'date_inscription',
        'valide',
        'derniere_connexion',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'           => 'hashed',
        'date_inscription'   => 'date',
        'valide'             => 'boolean',
        'derniere_connexion' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Vérifie si l’utilisateur a une permission via son rôle
     */
    public function hasPermission(string $permission): bool
    {
        return (bool) $this->role?->hasPermission($permission);
    }

    /**
     * Vérifie si l’utilisateur a exactement ce rôle
     */
    public function hasRole(string $roleName): bool
    {
        return strtolower($this->role?->nom) === strtolower($roleName);
    }

    // Helpers par rôle
    public function isAdmin(): bool
    {
        return $this->hasRole('Admin');
    }

    public function isTresorier(): bool
    {
        return $this->hasRole('Trésorier');
    }

    public function isResponsablePedagogique(): bool
    {
        return $this->hasRole('Responsable pédagogique');
    }

    public function isMembre(): bool
    {
        return $this->hasRole('Membre');
    }

    /**
     * Vérifie la hiérarchie des rôles
     */
    public function hasAtLeastRole(string $requiredRole): bool
    {
        $hierarchy = [
            'Admin' => 4,
            'Trésorier' => 3,
            'Responsable pédagogique' => 2,
            'Membre' => 1,
        ];

        $userRole = $this->role?->nom;

        if (!$userRole || !isset($hierarchy[$userRole]) || !isset($hierarchy[$requiredRole])) {
            return false;
        }

        return $hierarchy[$userRole] >= $hierarchy[$requiredRole];
    }
}

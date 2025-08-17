<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Créer les rôles
        $adminRole = Role::create(['nom' => 'Admin']);
        $tresorierRole = Role::create(['nom' => 'Trésorier']);
        $membreRole = Role::create(['nom' => 'Membre']);
        $responsablePedagogiqueRole = Role::create(['nom' => 'Responsable pédagogique']);

        $adminRole = Role::create([
            'nom' => 'Admin',
            'permissions' => ['all'], // Admin a tous les droits
        ]);

        $tresorierRole = Role::create([
            'nom' => 'Trésorier',
            'permissions' => ['manage_tresorier', 'manage_membre'],
        ]);

        $responsablePedagogiqueRole = Role::create([
            'nom' => 'Responsable pédagogique',
            'permissions' => ['manage_resp_pedagogique', 'manage_membre'],
        ]);

        $membreRole = Role::create([
            'nom' => 'Membre',
            'permissions' => ['view_membre'],
        ]);

        // 2. Créer un utilisateur par rôle
        User::create([
            'nom' => 'Admin',
            'prenom' => 'AEERG',
            'statut' => 'Etudiant',
            'email' => 'admin@aeerg.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
        ]);

        User::create([
            'nom' => 'Diallo',
            'prenom' => 'Mamadou',
            'statut' => 'Etudiant',
            'email' => 'tresorier@aeerg.com',
            'password' => Hash::make('password'),
            'role_id' => $tresorierRole->id,
        ]);

        User::create([
            'nom' => 'Gueye',
            'prenom' => 'Abdoul',
            'statut' => 'Eléve',
            'email' => 'membre@aeerg.com',
            'password' => Hash::make('password'),
            'role_id' => $membreRole->id,
        ]);

        User::create([
            'nom' => 'Sow',
            'prenom' => 'Fatou',
            'statut' => 'Professionnel',
            'email' => 'responsable.pedagogique@aeerg.com',
            'password' => Hash::make('password'),
            'role_id' => $responsablePedagogiqueRole->id,
        ]);
    }
}

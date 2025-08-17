<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'permissions'];

    protected $casts = [
        'permissions' => 'array', // JSON stocké dans la DB
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Vérifie si le rôle possède la permission demandée
     */
    public function hasPermission(string $permission): bool
    {
        if (!$this->permissions) {
            return false;
        }

        // Admin a toujours tous les droits
        if ($this->nom === 'Admin') {
            return true;
        }

        return in_array($permission, $this->permissions);
    }
}

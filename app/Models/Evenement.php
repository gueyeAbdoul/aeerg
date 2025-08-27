<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evenement extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'description',
        'date_debut',
        'date_fin',
        'lieu',
        'createur_id',
    ];

    // 🔗 Créateur de l’événement
    public function createur()
    {
        return $this->belongsTo(User::class, 'createur_id');
    }

    // 🔗 Inscriptions (relation pivot user ↔ événement)
    public function participants()
    {
        return $this->belongsToMany(User::class, 'evenement_user')
                    ->withTimestamps();
    }
}

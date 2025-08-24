<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Document extends Model
{
    protected $fillable = ['titre', 'chemin_fichier', 'proprietaire_id', 'is_disponible', 'date_ajout'];

    public function proprietaire(): BelongsTo
    {
        return $this->belongsTo(User::class, 'proprietaire_id');
    }

    // Relation vers l'emprunt actif
    public function emprunt_actif(): HasOne
    {
        return $this->hasOne(Emprunt::class)->where('statut', 'actif');
    }

    public function emprunts()
    {
        return $this->hasMany(Emprunt::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cotisation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'montant',
        'date_paiement',
        'statut',
        'methode',
    ];

    // Relation avec User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

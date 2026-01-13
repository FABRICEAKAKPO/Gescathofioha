<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeMesse extends Model
{
    use HasFactory;

    protected $table = 'demandes_messe';

    protected $fillable = [
        'demandeur',
        'intentions',
        'type_messe',
        'prix',
        'montant_paye',
        'date_celebration',
        'heure_celebration',
        'numero_recu',
        'statut',
    ];

    protected $casts = [
        'prix' => 'decimal:2',
        'montant_paye' => 'decimal:2',
        'date_celebration' => 'date',
    ];

    public function celebrations()
    {
        return $this->hasMany(Celebration::class, 'demande_messe_id');
    }

    public function recettes()
    {
        return $this->hasMany(Recette::class, 'demande_messe_id');
    }
}
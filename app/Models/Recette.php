<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recette extends Model
{
    use HasFactory;

    protected $table = 'recettes';

    protected $fillable = [
        'type',
        'montant',
        'date',
        'demande_messe_id',
    ];

    protected $casts = [
        'montant' => 'decimal:2',
        'date' => 'date',
    ];

    public function demandeMesse()
    {
        return $this->belongsTo(DemandeMesse::class, 'demande_messe_id', 'id');
    }
}
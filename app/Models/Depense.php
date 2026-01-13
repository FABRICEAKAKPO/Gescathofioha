<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depense extends Model
{
    use HasFactory;

    protected $table = 'depenses';

    protected $fillable = [
        'motif',
        'montant',
        'nom_encaisseur',
        'prenom_encaisseur',
        'date',
    ];

    protected $casts = [
        'montant' => 'decimal:2',
        'date' => 'date',
    ];
}
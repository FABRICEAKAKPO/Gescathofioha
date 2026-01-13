<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Celebration extends Model
{
    use HasFactory;

    protected $table = 'celebrations';

    protected $fillable = [
        'demande_messe_id',
        'date_celebration',
        'heure_celebration',
        'statut',
    ];

    protected $casts = [
        'date_celebration' => 'date',
    ];

    public function demandeMesse()
    {
        return $this->belongsTo(DemandeMesse::class, 'demande_messe_id', 'id');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\DemandeMesse;
use App\Models\Celebration;
use App\Models\Recette;
use App\Models\Depense;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RapportController extends Controller
{
    public function intentions(Request $request): View
    {
        $date = $request->get('date', today()->format('Y-m-d'));
        
        // Récupérer les célébrations pour la date spécifiée
        $celebrations = Celebration::where('date_celebration', $date)
            ->with('demandeMesse')
            ->orderBy('heure_celebration', 'asc')
            ->get();
        
        return view('rapports.intentions', compact('celebrations', 'date'));
    }

    public function caisse(Request $request): View
    {
        $dateDebut = $request->get('date_debut', today()->startOfMonth()->format('Y-m-d'));
        $dateFin = $request->get('date_fin', today()->format('Y-m-d'));
        
        // Récupérer les recettes dans la période
        $recettes = Recette::whereBetween('date', [$dateDebut, $dateFin])
            ->orderBy('date', 'asc')
            ->get();
        
        // Récupérer les dépenses dans la période
        $depenses = Depense::whereBetween('date', [$dateDebut, $dateFin])
            ->orderBy('date', 'asc')
            ->get();
        
        // Calculer les totaux
        $total_recettes = $recettes->sum('montant');
        $total_depenses = $depenses->sum('montant');
        $solde = $total_recettes - $total_depenses;
        
        // Calculer les totaux par type de recette
        $recettes_par_type = $recettes->groupBy('type')
            ->map(function ($items) {
                return $items->sum('montant');
            });
        
        // Calculer les totaux par motif de dépense
        $depenses_par_motif = $depenses->groupBy('motif')
            ->map(function ($items) {
                return $items->sum('montant');
            });
        
        return view('rapports.caisse', compact(
            'recettes', 
            'depenses', 
            'total_recettes', 
            'total_depenses', 
            'solde', 
            'dateDebut', 
            'dateFin',
            'recettes_par_type',
            'depenses_par_motif'
        ));
    }
}
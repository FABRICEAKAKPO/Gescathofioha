<?php

namespace App\Http\Controllers;

use App\Models\DemandeMesse;
use App\Models\Celebration;
use App\Models\Recette;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class DemandeMesseController extends Controller
{
    public function index(): View
    {
        $celebrations = Celebration::with('demandeMesse')
            ->orderBy('date_celebration', 'desc')
            ->orderBy('heure_celebration', 'asc')
            ->paginate(20);
        
        // Statistiques par type de messe
        $statsParType = DemandeMesse::selectRaw('type_messe, COUNT(*) as count')
            ->groupBy('type_messe')
            ->get();
        
        return view('demandes.index', compact('celebrations', 'statsParType'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'demandeur' => 'required|string|max:255',
            'intentions' => 'required|string',
            'type_messe' => 'required|in:QUOTIDIEN,DOMINICAL,TRIDUUM,NEUVAINE,TRENTAINE,MARIAGE,DEFUNT,SPECIALE,VEILLEE,ENTERREMENT',
            'montant_paye' => 'required|numeric',
            'date_celebration' => 'required|date',
            'heure_celebration' => 'required|date_format:H:i',
        ]);

        // Générer un numéro de reçu unique
        $numeroRecu = 'REC-' . date('Y') . '-' . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);

        $demande = DemandeMesse::create([
            'demandeur' => $request->demandeur,
            'intentions' => $request->intentions,
            'type_messe' => $request->type_messe,
            'prix' => $request->montant_paye, // Pour simplifier, on utilise le montant payé comme prix
            'montant_paye' => $request->montant_paye,
            'date_celebration' => $request->date_celebration,
            'heure_celebration' => $request->heure_celebration,
            'numero_recu' => $numeroRecu,
            'statut' => 'en_attente',
        ]);

        // Créer automatiquement un enregistrement de recette pour le paiement
        \App\Models\Recette::create([
            'type' => $request->type_messe,
            'montant' => $request->montant_paye,
            'date' => now()->format('Y-m-d'),
            'demande_messe_id' => $demande->id,
        ]);

        // Pour les types de messe multiples (TRIDUUM, NEUVAINE, TRENTAINE), créer des célébrations individuelles
        if (in_array($request->type_messe, ['TRIDUUM', 'NEUVAINE', 'TRENTAINE'])) {
            $nbJours = $request->type_messe === 'TRIDUUM' ? 3 : ($request->type_messe === 'NEUVAINE' ? 9 : 30);
            
            $date = \Carbon\Carbon::parse($request->date_celebration);
            for ($i = 0; $i < $nbJours; $i++) {
                $dateCelebration = $date->copy()->addDays($i);
                
                Celebration::create([
                    'demande_messe_id' => $demande->id,
                    'date_celebration' => $dateCelebration->format('Y-m-d'),
                    'heure_celebration' => $request->heure_celebration,
                    'statut' => 'en_attente',
                ]);
            }
        } else {
            // Pour les messes simples, créer une célébration unique
            Celebration::create([
                'demande_messe_id' => $demande->id,
                'date_celebration' => $request->date_celebration,
                'heure_celebration' => $request->heure_celebration,
                'statut' => 'en_attente',
            ]);
        }

        return redirect()->route('demandes.index')->with('success', 'Demande de messe enregistrée avec succès');
    }

    public function destroy($id): RedirectResponse
    {
        $demande = DemandeMesse::findOrFail($id);
        
        // Supprimer les célébrations associées
        $demande->celebrations()->delete();
        
        // Supprimer les recettes associées
        $demande->recettes()->delete();
        
        // Supprimer la demande de messe
        $demande->delete();
        
        return redirect()->route('demandes.index')->with('success', 'Demande de messe supprimée avec succès');
    }

    public function recu(int $id): View
    {
        $demande = DemandeMesse::findOrFail($id);
        
        return view('demandes.recu', compact('demande'));
    }
}
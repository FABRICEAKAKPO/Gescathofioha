<?php

namespace App\Http\Controllers;

use App\Models\Recette;
use App\Models\Depense;
use App\Models\DemandeMesse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;

class ComptableController extends Controller
{
    public function index(): View
    {
        // Calculer les statistiques pour le comptable
        $stats = [
            'recettes_mois' => Recette::whereMonth('date', now()->month)->whereYear('date', now()->year)->sum('montant'),
            'depenses_mois' => Depense::whereMonth('date', now()->month)->whereYear('date', now()->year)->sum('montant'),
            'solde_mois' => Recette::whereMonth('date', now()->month)->whereYear('date', now()->year)->sum('montant') - Depense::whereMonth('date', now()->month)->whereYear('date', now()->year)->sum('montant'),
        ];

        return view('comptable.dashboard', compact('stats'));
    }

    public function recettes(): View
    {
        $recettes = Recette::with('demandeMesse')
            ->orderBy('date', 'desc')
            ->paginate(20);
        
        $total_recettes = Recette::sum('montant');
        
        return view('comptable.recettes', compact('recettes', 'total_recettes'));
    }

    public function storeRecette(Request $request): RedirectResponse
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'montant' => 'required|numeric',
            'date' => 'required|date',
        ]);

        Recette::create([
            'type' => $request->type,
            'montant' => $request->montant,
            'date' => $request->date,
        ]);

        return redirect()->route('comptable.recettes')->with('success', 'Recette enregistrée avec succès');
    }

    public function depenses(): View
    {
        $depenses = Depense::orderBy('date', 'desc')
            ->paginate(20);
        
        $total_depenses = Depense::sum('montant');
        
        return view('comptable.depenses', compact('depenses', 'total_depenses'));
    }

    public function storeDepense(Request $request): RedirectResponse
    {
        $request->validate([
            'motif' => 'required|string|max:255',
            'montant' => 'required|numeric',
            'prenom_encaisseur' => 'required|string|max:255',
            'nom_encaisseur' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        Depense::create([
            'motif' => $request->motif,
            'montant' => $request->montant,
            'prenom_encaisseur' => $request->prenom_encaisseur,
            'nom_encaisseur' => $request->nom_encaisseur,
            'date' => $request->date,
        ]);

        return redirect()->route('comptable.depenses')->with('success', 'Dépense enregistrée avec succès');
    }

    public function rapportsCaisse(): View
    {
        $dateDebut = request('date_debut', now()->subMonth()->format('Y-m-d'));
        $dateFin = request('date_fin', now()->format('Y-m-d'));
        $type = request('type', 'details'); // 'details' ou 'totaux'

        $recettes = Recette::whereBetween('date', [$dateDebut, $dateFin])
            ->orderBy('date', 'asc')
            ->get();

        $depenses = Depense::whereBetween('date', [$dateDebut, $dateFin])
            ->orderBy('date', 'asc')
            ->get();

        $totalRecettes = $recettes->sum('montant');
        $totalDepenses = $depenses->sum('montant');
        $solde = $totalRecettes - $totalDepenses;

        // Regroupement par type pour les totaux
        $recettesParType = [];
        foreach($recettes as $recette) {
            if (!isset($recettesParType[$recette->type])) {
                $recettesParType[$recette->type] = 0;
            }
            $recettesParType[$recette->type] += $recette->montant;
        }

        return view('comptable.rapports.caisse', compact(
            'recettes', 
            'depenses', 
            'totalRecettes', 
            'totalDepenses', 
            'solde',
            'recettesParType',
            'dateDebut', 
            'dateFin',
            'type'
        ));
    }

    public function suivrePaiements(): View
    {
        $demandes = DemandeMesse::orderBy('created_at', 'desc')
            ->paginate(20);

        $totalDemandes = DemandeMesse::count();
        $totalPaye = DemandeMesse::sum('montant_paye');
        $totalDu = DemandeMesse::where('montant_paye', '<', 'prix')->sum('prix') - DemandeMesse::where('montant_paye', '<', 'prix')->sum('montant_paye');

        return view('comptable.suivi-paiements', compact('demandes', 'totalDemandes', 'totalPaye', 'totalDu'));
    }
}

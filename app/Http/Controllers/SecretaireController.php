<?php

namespace App\Http\Controllers;

use App\Models\DemandeMesse;
use App\Models\Recette;
use App\Models\Depense;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;

class SecretaireController extends Controller
{
    public function index(): View
    {
        // Calculer les statistiques pour le secrétaire
        $stats = [
            'demandes_jour' => DemandeMesse::whereDate('created_at', Carbon::today())->count(),
            'demandes_total' => DemandeMesse::count(),
        ];

        // Récupérer les demandes récentes
        $recentes_demandes = DemandeMesse::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('secretaire.dashboard', compact('stats', 'recentes_demandes'));
    }

    public function demandes(): View
    {
        $demandes = DemandeMesse::with(['celebrations' => function($query) {
            $query->orderBy('date_celebration', 'asc')
                  ->orderBy('heure_celebration', 'asc');
        }])
        ->orderBy('date_celebration', 'desc')
        ->orderBy('heure_celebration', 'asc')
        ->paginate(20);
        
        // Statistiques par type de messe
        $statsParType = DemandeMesse::selectRaw('type_messe, COUNT(*) as count')
            ->groupBy('type_messe')
            ->get();
        
        return view('secretaire.demandes', compact('demandes', 'statsParType'));
    }

    public function storeDemande(Request $request): RedirectResponse
    {
        $request->validate([
            'demandeur' => 'required|string|max:255',
            'intentions' => 'required|string',
            'type_messe' => 'required|in:QUOTIDIEN,DOMINICAL,TRIDUUM,NEUVAINE,TRENTAINE,MARIAGE,DEFUNT,SPECIALE',
            'montant_paye' => 'required|numeric',
            'date_celebration' => 'required|date',
            'heure_celebration' => 'required|date_format:H:i',
        ]);

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
                \App\Models\Celebration::create([
                    'demande_messe_id' => $demande->id,
                    'date_celebration' => $date->copy()->addDays($i)->format('Y-m-d'),
                    'heure_celebration' => $request->heure_celebration,
                ]);
            }
        } else {
            // Pour les messes simples, créer une célébration unique
            \App\Models\Celebration::create([
                'demande_messe_id' => $demande->id,
                'date_celebration' => $request->date_celebration,
                'heure_celebration' => $request->heure_celebration,
            ]);
        }

        return redirect()->route('secretaire.demandes')->with('success', 'Demande de messe enregistrée avec succès');
    }

    public function recettes(): View
    {
        $recettes = Recette::with('demandeMesse')
            ->orderBy('date', 'desc')
            ->paginate(20);
        
        $total_recettes = Recette::sum('montant');
        
        return view('secretaire.recettes', compact('recettes', 'total_recettes'));
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

        return redirect()->route('secretaire.recettes')->with('success', 'Recette enregistrée avec succès');
    }

    public function depenses(): View
    {
        // Pour le secrétaire, on peut limiter aux dépenses liées à son compte
        $depenses = Depense::orderBy('date', 'desc')
            ->paginate(20);
        
        $total_depenses = Depense::sum('montant');
        
        return view('secretaire.depenses', compact('depenses', 'total_depenses'));
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

        return redirect()->route('secretaire.depenses')->with('success', 'Dépense enregistrée avec succès');
    }

    public function rapportsIntentions(): View
    {
        $dateDebut = request('date_debut', now()->subMonth()->format('Y-m-d'));
        $dateFin = request('date_fin', now()->format('Y-m-d'));

        // Récupérer les célébrations avec les intentions triées par date et heure
        $celebrationsHeure = \App\Models\Celebration::with(['demandeMesse' => function($query) {
            $query->orderBy('heure_celebration', 'asc');
        }])
        ->whereBetween('date_celebration', [$dateDebut, $dateFin])
        ->orderBy('date_celebration', 'asc')
        ->orderBy('heure_celebration', 'asc')
        ->get();

        // Regrouper par heure de célébration
        $groupedCelebrations = [];
        foreach($celebrationsHeure as $celebration) {
            $heure = $celebration->heure_celebration;
            if (!isset($groupedCelebrations[$heure])) {
                $groupedCelebrations[$heure] = [];
            }
            $groupedCelebrations[$heure][] = $celebration;
        }

        return view('secretaire.rapports.intentions', compact('celebrationsHeure', 'groupedCelebrations', 'dateDebut', 'dateFin'));
    }
}

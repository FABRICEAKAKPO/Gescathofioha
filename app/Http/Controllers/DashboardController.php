<?php

namespace App\Http\Controllers;

use App\Models\DemandeMesse;
use App\Models\Recette;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Calculer les statistiques du jour
        $stats = [
            'demandes_jour' => DemandeMesse::whereDate('created_at', Carbon::today())->count(),
            'paiements_jour' => Recette::whereDate('date', Carbon::today())->sum('montant'),
            'messes_demain' => DemandeMesse::whereDate('date_celebration', Carbon::tomorrow())
                ->whereIn('statut', ['en_attente', 'celebree'])
                ->count(),
        ];

        // Récupérer les demandes récentes
        $recentes_demandes = DemandeMesse::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Gérer la navigation du calendrier
        $mois = request('mois', Carbon::now()->month);
        $annee = request('annee', Carbon::now()->year);
        $dateCourante = Carbon::create($annee, $mois, 1);

        return view('dashboard', compact('stats', 'recentes_demandes', 'dateCourante'));
    }
}
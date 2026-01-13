<?php

namespace App\Http\Controllers;

use App\Models\Recette;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class RecetteController extends Controller
{
    public function index(): View
    {
        $recettes = Recette::with('demandeMesse')
            ->orderBy('date', 'desc')
            ->paginate(20);
        
        $total_recettes = Recette::sum('montant');
        
        return view('recettes.index', compact('recettes', 'total_recettes'));
    }
    
    public function store(Request $request): RedirectResponse
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

        return redirect()->route('recettes.index')->with('success', 'Recette enregistrée avec succès');
    }
    
    public function destroy($id): RedirectResponse
    {
        $recette = Recette::findOrFail($id);
        $recette->delete();
        
        return redirect()->route('recettes.index')->with('success', 'Recette supprimée avec succès');
    }
}
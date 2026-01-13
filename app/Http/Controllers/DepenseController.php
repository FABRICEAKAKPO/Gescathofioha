<?php

namespace App\Http\Controllers;

use App\Models\Depense;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class DepenseController extends Controller
{
    public function index(): View
    {
        $depenses = Depense::orderBy('date', 'desc')
            ->paginate(20);
        
        $total_depenses = Depense::sum('montant');
        
        return view('depenses.index', compact('depenses', 'total_depenses'));
    }
    
    public function store(Request $request): RedirectResponse
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

        return redirect()->route('depenses.index')->with('success', 'Dépense enregistrée avec succès');
    }
    
    public function destroy($id): RedirectResponse
    {
        $depense = Depense::findOrFail($id);
        $depense->delete();
        
        return redirect()->route('depenses.index')->with('success', 'Dépense supprimée avec succès');
    }
}
@extends('layout')

@section('title', 'Rapport de Caisse - Comptable')
@section('page-title', 'Rapport de Caisse - Comptable')

@section('content')
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <form method="GET" action="{{ route('comptable.rapports.caisse') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Date de début</label>
            <input type="date" name="date_debut" value="{{ $dateDebut }}" 
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Date de fin</label>
            <input type="date" name="date_fin" value="{{ $dateFin }}" 
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Type de rapport</label>
            <select name="type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="details" {{ $type === 'details' ? 'selected' : '' }}>Détails</option>
                <option value="totaux" {{ $type === 'totaux' ? 'selected' : '' }}>Totaux par type</option>
            </select>
        </div>
        
        <div class="flex items-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-filter mr-2"></i>Filtrer
            </button>
        </div>
    </form>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold">Rapport de Caisse</h2>
            <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-print mr-2"></i>Imprimer
            </button>
        </div>
        
        <div class="mb-6 text-center">
            <h3 class="text-lg font-semibold">Période: {{ \Carbon\Carbon::parse($dateDebut)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($dateFin)->format('d/m/Y') }}</h3>
        </div>
        
        <!-- Résumé financier -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                <p class="text-green-800 font-medium">Total Recettes</p>
                <p class="text-2xl font-bold text-green-600">{{ number_format($totalRecettes, 0, ',', ' ') }} FCFA</p>
            </div>
            
            <div class="bg-red-50 rounded-lg p-4 border border-red-200">
                <p class="text-red-800 font-medium">Total Dépenses</p>
                <p class="text-2xl font-bold text-red-600">{{ number_format($totalDepenses, 0, ',', ' ') }} FCFA</p>
            </div>
            
            <div class="bg-{{ $solde >= 0 ? 'blue' : 'red' }}-50 rounded-lg p-4 border border-{{ $solde >= 0 ? 'blue' : 'red' }}-200">
                <p class="text-{{ $solde >= 0 ? 'blue' : 'red' }}-800 font-medium">Solde</p>
                <p class="text-2xl font-bold {{ $solde >= 0 ? 'text-blue-600' : 'text-red-600' }}">{{ number_format($solde, 0, ',', ' ') }} FCFA</p>
            </div>
        </div>
        
        @if($type === 'totaux')
            <!-- Vue par totaux -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold mb-4">Totaux par type de recette</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type de Recette</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Montant</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($recettesParType as $type => $montant)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $type }}</td>
                                <td class="px-6 py-4 whitespace-nowrap font-semibold text-green-600">{{ number_format($montant, 0, ',', ' ') }} FCFA</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="px-6 py-4 text-center text-gray-500">Aucune recette pour cette période</td>
                            </tr>
                            @endforelse
                            
                            @if(count($recettesParType) > 0)
                            <tr class="bg-gray-100 font-semibold">
                                <td class="px-6 py-4 whitespace-nowrap">Total</td>
                                <td class="px-6 py-4 whitespace-nowrap text-green-600">{{ number_format($totalRecettes, 0, ',', ' ') }} FCFA</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <!-- Vue détaillée -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold mb-4">Détail des Recettes</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Montant</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Référence</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($recettes as $recette)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $recette->date->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $recette->type }}</td>
                                <td class="px-6 py-4 whitespace-nowrap font-semibold text-green-600">{{ number_format($recette->montant, 0, ',', ' ') }} FCFA</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($recette->demande_messe_id)
                                        <a href="{{ route('demandes.recu', $recette->demandeMesse->id) }}" class="text-blue-600 hover:text-blue-900">
                                            {{ $recette->demandeMesse->numero_recu }}
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">Aucune recette pour cette période</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="mb-8">
                <h3 class="text-lg font-semibold mb-4">Détail des Dépenses</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Motif</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Montant</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Encaisseur</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($depenses as $depense)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $depense->date->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $depense->motif }}</td>
                                <td class="px-6 py-4 whitespace-nowrap font-semibold text-red-600">{{ number_format($depense->montant, 0, ',', ' ') }} FCFA</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $depense->prenom_encaisseur }} {{ $depense->nom_encaisseur }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">Aucune dépense pour cette période</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
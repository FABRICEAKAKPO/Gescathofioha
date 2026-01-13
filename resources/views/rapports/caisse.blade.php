@extends('layout')

@section('title', 'Rapport Caisse')
@section('page-title', 'Rapport de Caisse')


@section('content')
<div class="mb-6">
    <form method="GET" class="bg-white rounded-lg shadow p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Date Début</label>
                <input type="date" name="date_debut" value="{{ $dateDebut }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Date Fin</label>
                <input type="date" name="date_fin" value="{{ $dateFin }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Type de Rapport</label>
                <select name="type_rapport" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    <option value="total" {{ request('type_rapport') == 'total' ? 'selected' : '' }}>Totaux par Type</option>
                    <option value="detail" {{ request('type_rapport') == 'detail' ? 'selected' : '' }}>Détails</option>
                </select>
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                <i class="fas fa-search mr-2"></i>Générer
            </button>
        </div>
    </form>
</div>

<div class="bg-white rounded-lg shadow" id="rapport-caisse">
    <div class="p-6 border-b">
        <div class="flex justify-between items-center">
            <div>
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-20 h-20 mx-auto"
                <h3 class="text-xl font-semibold">Rapport de Caisse</h3>
                <p class="text-gray-600">
                    Période: {{ \Carbon\Carbon::parse($dateDebut)->format('d/m/Y') }}
                    au {{ \Carbon\Carbon::parse($dateFin)->format('d/m/Y') }}
                </p>
                <p class="text-gray-600">
                    Type: {{ request('type_rapport') == 'detail' ? 'Détails' : 'Totaux par Type' }}
                </p>
            </div>
            <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-print mr-2"></i>Imprimer
            </button>
        </div>
    </div>

    <div class="p-6">
        <!-- Résumé -->
        <div class="grid grid-cols-3 gap-6 mb-8">
            <div class="bg-green-50 rounded-lg p-4 border-l-4 border-green-500">
                <p class="text-sm text-gray-600">Total Recettes</p>
                <p class="text-2xl font-bold text-green-600">{{ number_format($total_recettes, 0, ',', ' ') }} FCFA</p>
            </div>
            <div class="bg-red-50 rounded-lg p-4 border-l-4 border-red-500">
                <p class="text-sm text-gray-600">Total Dépenses</p>
                <p class="text-2xl font-bold text-red-600">{{ number_format($total_depenses, 0, ',', ' ') }} FCFA</p>
            </div>
            <div class="bg-blue-50 rounded-lg p-4 border-l-4 border-blue-500">
                <p class="text-sm text-gray-600">Solde</p>
                <p class="text-2xl font-bold {{ $solde >= 0 ? 'text-blue-600' : 'text-red-600' }}">
                    {{ number_format($solde, 0, ',', ' ') }} FCFA
                </p>
            </div>
        </div>

        @if(request('type_rapport') == 'total' || !request('type_rapport'))
            <!-- Répartition des Recettes par Type -->
            <div class="mb-8">
                <h4 class="text-lg font-semibold mb-4 text-green-700">Répartition des Recettes par Type</h4>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Montant</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($recettes_par_type as $type => $montant)
                            <tr>
                                <td class="px-6 py-4 text-sm">{{ $type }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-semibold text-green-600">
                                    {{ number_format($montant, 0, ',', ' ') }} FCFA
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-6 py-4 text-center text-gray-500">Aucune recette</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Répartition des Dépenses par Motif -->
            <div class="mb-8">
                <h4 class="text-lg font-semibold mb-4 text-red-700">Répartition des Dépenses par Motif</h4>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Motif</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Montant</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($depenses_par_motif as $motif => $montant)
                            <tr>
                                <td class="px-6 py-4 text-sm">{{ $motif }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-semibold text-red-600">
                                    {{ number_format($montant, 0, ',', ' ') }} FCFA
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-6 py-4 text-center text-gray-500">Aucune dépense</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @else
            <!-- Détails Recettes -->
            <div class="mb-8">
                <h4 class="text-lg font-semibold mb-4 text-green-700">Détail des Recettes</h4>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Montant</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($recettes as $recette)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $recette->date->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 text-sm">{{ $recette->type }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-semibold text-green-600">
                                    {{ number_format($recette->montant, 0, ',', ' ') }} FCFA
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-gray-500">Aucune recette</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Détails Dépenses -->
            <div>
                <h4 class="text-lg font-semibold mb-4 text-red-700">Détail des Dépenses</h4>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Motif</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Encaisseur</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Montant</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($depenses as $depense)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $depense->date->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 text-sm">{{ $depense->motif }}</td>
                                <td class="px-6 py-4 text-sm">{{ $depense->prenom_encaisseur }} {{ $depense->nom_encaisseur }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-semibold text-red-600">
                                    {{ number_format($depense->montant, 0, ',', ' ') }} FCFA
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">Aucune dépense</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<style>
@media print {
    body * {
        visibility: hidden;
    }
    #rapport-caisse, #rapport-caisse * {
        visibility: visible;
    }
    #rapport-caisse {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
    button {
        display: none !important;
    }
}
</style>
@endsection
@extends('layout')

@section('title', 'Recettes - Comptable')
@section('page-title', 'Recettes - Comptable')

@section('content')
<div class="mb-6">
    <button onclick="document.getElementById('modal-add-recette').classList.remove('hidden')" 
            class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg">
        <i class="fas fa-plus mr-2"></i>Ajouter une Recette
    </button>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Total Recettes</p>
                <h3 class="text-3xl font-bold text-green-600">{{ number_format($total_recettes, 0, ',', ' ') }} FCFA</h3>
            </div>
            <div class="bg-green-100 rounded-full p-3">
                <i class="fas fa-money-bill-wave text-green-600 text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-6">
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
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-800">{{ $recette->type }}</span>
                    </td>
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
                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">Aucune recette enregistrée</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-6">
        {{ $recettes->links() }}
    </div>
</div>

<!-- Modal Ajouter Recette -->
<div id="modal-add-recette" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg w-full max-w-2xl mx-4 max-h-screen overflow-y-auto">
        <div class="p-6 border-b">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold">Nouvelle Recette</h3>
                <button onclick="document.getElementById('modal-add-recette').classList.add('hidden')" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
        
        <form action="{{ route('comptable.store-recette') }}" method="POST" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type de Recette</label>
                    <select name="type" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">Sélectionner un type</option>
                        <option value="QUOTIDIEN">Messe Quotidien</option>
                        <option value="DOMINICAL">Messe Dominical</option>
                        <option value="TRIDUUM">Messe Triduum</option>
                        <option value="NEUVAINE">Messe Neuvaine</option>
                        <option value="TRENTAINE">Messe Trentaine</option>
                        <option value="MARIAGE">Messe de Mariage</option>
                        <option value="DEFUNT">Messe pour Défunt</option>
                        <option value="SPECIALE">Messe Spéciale</option>
                        <option value="OFFICE_DIVIN">Office Divin</option>
                        <option value="BENEDICTION">Bénédiction</option>
                        <option value="BAPTÊME">Baptême</option>
                        <option value="MARIAGE_CIVIL">Mariage Civil</option>
                        <option value="SEPULTURE">Sépulture</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Montant (FCFA)</label>
                    <input type="number" name="montant" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                    <input type="date" name="date" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" onclick="document.getElementById('modal-add-recette').classList.add('hidden')"
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Annuler
                </button>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
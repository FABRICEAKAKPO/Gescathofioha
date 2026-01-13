@extends('layout')

@section('title', 'Dépenses - Comptable')
@section('page-title', 'Dépenses - Comptable')

@section('content')
<div class="mb-6">
    <button onclick="document.getElementById('modal-add-depense').classList.remove('hidden')" 
            class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg">
        <i class="fas fa-plus mr-2"></i>Ajouter une Dépense
    </button>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Total Dépenses</p>
                <h3 class="text-3xl font-bold text-red-600">{{ number_format($total_depenses, 0, ',', ' ') }} FCFA</h3>
            </div>
            <div class="bg-red-100 rounded-full p-3">
                <i class="fas fa-money-bill-wave text-red-600 text-2xl"></i>
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
                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">Aucune dépense enregistrée</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-6">
        {{ $depenses->links() }}
    </div>
</div>

<!-- Modal Ajouter Dépense -->
<div id="modal-add-depense" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg w-full max-w-2xl mx-4 max-h-screen overflow-y-auto">
        <div class="p-6 border-b">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold">Nouvelle Dépense</h3>
                <button onclick="document.getElementById('modal-add-depense').classList.add('hidden')" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
        
        <form action="{{ route('comptable.store-depense') }}" method="POST" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Motif</label>
                    <input type="text" name="motif" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Montant (FCFA)</label>
                    <input type="number" name="montant" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Prénom Encaisseur</label>
                    <input type="text" name="prenom_encaisseur" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nom Encaisseur</label>
                    <input type="text" name="nom_encaisseur" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500">
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                    <input type="date" name="date" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500">
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" onclick="document.getElementById('modal-add-depense').classList.add('hidden')"
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Annuler
                </button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
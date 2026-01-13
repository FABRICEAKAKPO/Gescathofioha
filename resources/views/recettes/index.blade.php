@extends('layout')

@section('title', 'Recettes')
@section('page-title', 'Recettes')

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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
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
                    <td class="px-6 py-4 whitespace-nowrap">
                        <button onclick="confirmDeleteRecette({{ $recette->id }})" 
                                class="text-red-600 hover:text-red-900">
                            <i class="fas fa-trash"></i> Supprimer
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Aucune recette enregistrée</td>
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
        
        <form action="{{ route('recettes.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type de Recette</label>
                    <select name="type" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">Sélectionner un type</option>
                        <option value="QUETES_ORDINAIRE">Quêtes ordinaires:dimanche</option>
                        <option value="QUETES_ORDINAIRE_SEMAINE">Quêtes ordinaire:semaine</option>
                        <option value="QUETES_ORDINAIRE_FETE">Quêtes ordinaire:fête</option>
                        <option value="QUETES_DZIGBEZAN">Quêtes dzigbézan</option>
                        <option value="QUETES_IMPEREES">Quêtes imperées</option>
                        <option value="QUETES_VEILLEE">Quêtes veillées</option>
                        <option value="QUETES_DEFUNTS">Quêtes défunts</option>
                        <option value="DIME">Dîme</option>
                        <option value="DENIER_DU_CULTE">Denier du culte</option>
                        <option value="MESSE_ROSAIRE">Messe rosaire</option>
                        <option value="CAISSE_INTERNE">Caisse interne</option>
                        <option value="LOCATION_GRANDE_SALLE_SONO">Location grande salle et sono</option>
                        
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

<!-- Modal de confirmation de suppression recette -->
<div id="modal-delete-recette" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg w-full max-w-md mx-4">
        <div class="p-6 border-b">
            <h3 class="text-xl font-semibold">Confirmer la suppression</h3>
        </div>
        <div class="p-6">
            <p>Êtes-vous sûr de vouloir supprimer cette recette ? Cette action est irréversible.</p>
        </div>
        <div class="p-6 border-t flex justify-end space-x-3">
            <button onclick="document.getElementById('modal-delete-recette').classList.add('hidden')" 
                    class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                Annuler
            </button>
            <form id="delete-recette-form" method="POST" action="">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                    Supprimer
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function confirmDeleteRecette(id) {
    const form = document.getElementById('delete-recette-form');
    form.action = '/recettes/' + id;
    document.getElementById('modal-delete-recette').classList.remove('hidden');
}
</script>
@endsection
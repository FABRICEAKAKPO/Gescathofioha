@extends('layout')

@section('title', 'Demandes de Messe - Secrétaire')
@section('page-title', 'Demandes de Messe - Secrétaire')

@section('content')
@php
    use Illuminate\Support\Str;
@endphp

@if(isset($statsParType) && $statsParType->count() > 0)
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    @foreach($statsParType as $stat)
    <div class="bg-white rounded-lg shadow p-4">
        <div class="text-center">
            <p class="text-sm text-gray-600">{{ $stat->type_messe }}</p>
            <p class="text-2xl font-bold text-blue-600">{{ $stat->count }}</p>
        </div>
    </div>
    @endforeach
</div>
@endif

<div class="mb-6">
    <button onclick="document.getElementById('modal-add').classList.remove('hidden')" 
            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
        <i class="fas fa-plus mr-2"></i>Ajouter une Demande
    </button>
</div>

@if($demandes->count() > 0)
    @php
        $groupedCelebrations = [];
        foreach($demandes as $celebration) {
            $date = $celebration->date_celebration->format('Y-m-d');
            if (!isset($groupedCelebrations[$date])) {
                $groupedCelebrations[$date] = [];
            }
            $groupedCelebrations[$date][] = $celebration;
        }
        ksort($groupedCelebrations);
    @endphp
    
    @foreach($groupedCelebrations as $date => $celebrationsDuJour)
    <div class="mb-6">
        <h3 class="text-lg font-semibold mb-3 text-gray-700">{{ \Carbon\Carbon::parse($date)->format('d/m/Y') }} ({{ count($celebrationsDuJour) }} messe{{ count($celebrationsDuJour) > 1 ? 's' : '' }})</h3>
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reçu</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Demandeur</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Intentions</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Montant</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Heure</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($celebrationsDuJour as $celebration)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">{{ $celebration->numero_recu }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $celebration->demandeur }}</td>
                        <td class="px-6 py-4">{{ Str::limit($celebration->intentions, 40) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded bg-blue-100 text-blue-800">{{ $celebration->type_messe }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ number_format($celebration->montant_paye, 0, ',', ' ') }} FCFA</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $celebration->heure_celebration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('demandes.recu', $celebration->id) }}" 
                               class="text-blue-600 hover:text-blue-900 mr-3">
                                <i class="fas fa-receipt"></i> Reçu
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endforeach
@else
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reçu</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Demandeur</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Intentions</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Montant</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Heure</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">Aucune célébration prévue</td>
                </tr>
            </tbody>
        </table>
    </div>
@endif

<div class="mt-6">
    {{ $demandes->links() }}
</div>

<!-- Modal Ajouter Demande -->
<div id="modal-add" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg w-full max-w-2xl mx-4 max-h-screen overflow-y-auto">
        <div class="p-6 border-b">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold">Nouvelle Demande de Messe</h3>
                <button onclick="document.getElementById('modal-add').classList.add('hidden')" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
        
        <form action="{{ route('secretaire.store-demande') }}" method="POST" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Demandeur</label>
                    <input type="text" name="demandeur" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Intentions</label>
                    <textarea name="intentions" rows="3" required 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type de Messe</label>
                    <select name="type_messe" id="type_messe" required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            onchange="updatePrix()">
                        <option value="">Sélectionner...</option>
                        <option value="QUOTIDIEN" data-prix="1500">QUOTIDIEN (1,500 FCFA)</option>
                        <option value="DOMINICAL" data-prix="3000">DOMINICAL (3,000 FCFA)</option>
                        <option value="TRIDUUM" data-prix="5000">TRIDUUM (5,000 FCFA)</option>
                        <option value="NEUVAINE" data-prix="15000">NEUVAINE (15,000 FCFA)</option>
                        <option value="TRENTAINE" data-prix="30000">TRENTAINE (30,000 FCFA)</option>
                        <option value="MARIAGE" data-prix="5000">MARIAGE (5,000 FCFA)</option>
                        <option value="DEFUNT" data-prix="5000">DEFUNT (5,000 FCFA)</option>
                        <option value="SPECIALE" data-prix="5000">SPECIALE (5,000 FCFA)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Montant Payé (FCFA)</label>
                    <input type="number" name="montant_paye" id="montant_paye" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date de Célébration</label>
                    <input type="date" name="date_celebration" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Heure</label>
                    <input type="time" name="heure_celebration" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" onclick="document.getElementById('modal-add').classList.add('hidden')"
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Annuler
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function updatePrix() {
    const select = document.getElementById('type_messe');
    const montantInput = document.getElementById('montant_paye');
    const selectedOption = select.options[select.selectedIndex];
    const prix = selectedOption.getAttribute('data-prix');
    if (prix) {
        montantInput.value = prix;
    }
}
</script>
@endsection
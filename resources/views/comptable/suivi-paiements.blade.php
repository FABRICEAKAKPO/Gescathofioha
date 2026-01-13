@extends('layout')

@section('title', 'Suivi des Paiements - Comptable')
@section('page-title', 'Suivi des Paiements - Comptable')

@section('content')
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
            <p class="text-blue-800 font-medium">Total Demandes</p>
            <p class="text-2xl font-bold text-blue-600">{{ $totalDemandes }}</p>
        </div>
        
        <div class="bg-green-50 rounded-lg p-4 border border-green-200">
            <p class="text-green-800 font-medium">Total Payé</p>
            <p class="text-2xl font-bold text-green-600">{{ number_format($totalPaye, 0, ',', ' ') }} FCFA</p>
        </div>
        
        <div class="bg-yellow-50 rounded-lg p-4 border border-yellow-200">
            <p class="text-yellow-800 font-medium">Total dû</p>
            <p class="text-2xl font-bold text-yellow-600">{{ number_format($totalDu, 0, ',', ' ') }} FCFA</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <h3 class="text-lg font-semibold mb-4">Détail des Demandes et Paiements</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reçu</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Demandeur</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Prix</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Payé</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reste à payer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($demandes as $demande)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $demande->numero_recu }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $demande->demandeur }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs rounded bg-blue-100 text-blue-800">{{ $demande->type_messe }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap font-semibold">{{ number_format($demande->prix, 0, ',', ' ') }} FCFA</td>
                    <td class="px-6 py-4 whitespace-nowrap font-semibold text-green-600">{{ number_format($demande->montant_paye, 0, ',', ' ') }} FCFA</td>
                    <td class="px-6 py-4 whitespace-nowrap font-semibold {{ $demande->prix - $demande->montant_paye > 0 ? 'text-red-600' : 'text-green-600' }}">
                        {{ number_format($demande->prix - $demande->montant_paye, 0, ',', ' ') }} FCFA
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs rounded {{ $demande->montant_paye >= $demande->prix ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $demande->montant_paye >= $demande->prix ? 'Payé' : 'Partiel' }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">Aucune demande enregistrée</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-6">
        {{ $demandes->links() }}
    </div>
</div>
@endsection
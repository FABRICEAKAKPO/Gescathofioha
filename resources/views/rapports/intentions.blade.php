@extends('layout')

@section('title', 'Rapport Intentions')
@section('page-title', 'Rapport des Intentions de Messe')

@section('content')
<div class="mb-6">
    <form method="GET" class="bg-white rounded-lg shadow p-6">
        <div class="flex items-end space-x-4">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-2">Date de Célébration</label>
                <input type="date" name="date" value="{{ $date }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md">
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                <i class="fas fa-search mr-2"></i>Générer
            </button>
        </div>
    </form>
</div>

<div class="bg-white rounded-lg shadow" id="rapport-intentions">
    <div class="p-6 border-b">
        <div class="flex justify-between items-center">
            <div>
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-20 h-20 mx-auto">
                <h3 class="text-xl font-semibold">Intentions de Messe</h3>
                <p class="text-gray-600">Date: {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</p>
            </div>
            <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-print mr-2"></i>Imprimer
            </button>
        </div>
    </div>

    <div class="p-6">
        @if($celebrations->count() > 0)
            @php
                // Regrouper les célébrations par heure
                $groupedCelebrations = [];
                foreach($celebrations as $celebration) {
                    $heure = $celebration->heure_celebration;
                    if (!isset($groupedCelebrations[$heure])) {
                        $groupedCelebrations[$heure] = [];
                    }
                    $groupedCelebrations[$heure][] = $celebration;
                }
                ksort($groupedCelebrations);
            @endphp

            @foreach($groupedCelebrations as $heure => $celebrationsHeure)
            <div class="mb-6">
                <h4 class="text-lg font-semibold mb-3 text-gray-700">Heure: {{ $heure }} ({{ count($celebrationsHeure) }} messe{{ count($celebrationsHeure) > 1 ? 's' : '' }})</h4>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Demandeur</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Intentions</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($celebrationsHeure as $celebration)
                        <tr>
                            <td class="px-6 py-4">{{ $celebration->demandeMesse->demandeur }}</td>
                            <td class="px-6 py-4">{{ $celebration->demandeMesse->intentions }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs rounded bg-blue-100 text-blue-800">
                                    {{ $celebration->demandeMesse->type_messe }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <!-- Signature du célébrant pour cette heure -->
                <div class="mt-8">
                    <div class="flex justify-between items-end">
                        <div>
                            <p class="text-sm text-gray-600">Signature du célébrant</p>
                            <div class="h-16 w-48 border-b border-gray-300 mt-2"></div>
                        </div>
                        
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <p class="text-center text-gray-500 py-8">Aucune célébration prévue pour cette date</p>
        @endif
    </div>
</div>

<style>
@media print {
    body * {
        visibility: hidden;
    }
    #rapport-intentions, #rapport-intentions * {
        visibility: visible;
    }
    #rapport-intentions {
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
@extends('layout')

@section('title', 'Rapport des Intentions - Secrétaire')
@section('page-title', 'Rapport des Intentions - Secrétaire')

@section('content')
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <form method="GET" action="{{ route('secretaire.rapports.intentions') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
            <h2 class="text-xl font-semibold">Rapport des Intentions</h2>
            <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-print mr-2"></i>Imprimer
            </button>
        </div>
        
        <div class="mb-6 text-center">
            <h3 class="text-lg font-semibold">Période: {{ \Carbon\Carbon::parse($dateDebut)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($dateFin)->format('d/m/Y') }}</h3>
        </div>
        
        @if($celebrationsHeure->count() > 0)
            @foreach($groupedCelebrations as $heure => $celebrations)
            <div class="mb-8">
                <div class="border-b-2 border-gray-800 pb-2 mb-4">
                    <h3 class="text-lg font-semibold text-center">Heure: {{ $heure }}</h3>
                </div>
                
                <div class="space-y-4">
                    @foreach($celebrations as $celebration)
                    <div class="border border-gray-300 rounded-lg p-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="font-medium">{{ $celebration->demandeMesse->demandeur }}</p>
                                <p class="text-sm text-gray-600 mt-2">{{ $celebration->demandeMesse->intentions }}</p>
                                <p class="text-xs text-gray-500 mt-2">
                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded">{{ $celebration->demandeMesse->type_messe }}</span>
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm">Signature du célébrant: ________________</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        @else
            <p class="text-gray-500 text-center py-8">Aucune intention trouvée pour cette période</p>
        @endif
    </div>
</div>
@endsection
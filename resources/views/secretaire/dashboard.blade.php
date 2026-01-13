@extends('layout')

@section('title', 'Tableau de Bord - Secrétaire')
@section('page-title', 'Tableau de Bord - Secrétaire')

@section('content')
@php
    use Illuminate\Support\Str;
@endphp

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <!-- Demandes du jour -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Demandes du jour</p>
                <h3 class="text-3xl font-bold text-blue-600">{{ $stats['demandes_jour'] }}</h3>
            </div>
            <div class="bg-blue-100 rounded-full p-3">
                <i class="fas fa-calendar-day text-blue-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Total demandes -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Total Demandes</p>
                <h3 class="text-3xl font-bold text-green-600">{{ $stats['demandes_total'] }}</h3>
            </div>
            <div class="bg-green-100 rounded-full p-3">
                <i class="fas fa-praying-hands text-green-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Accès rapide -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Accès rapide</p>
                <div class="flex space-x-2 mt-2">
                    <a href="{{ route('secretaire.demandes') }}" class="bg-blue-600 text-white px-3 py-1 rounded text-sm">Demandes</a>
                    <a href="{{ route('secretaire.recettes') }}" class="bg-green-600 text-white px-3 py-1 rounded text-sm">Recettes</a>
                </div>
            </div>
            <div class="bg-purple-100 rounded-full p-3">
                <i class="fas fa-rocket text-purple-600 text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Demandes récentes -->
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold">Demandes Récentes</h2>
        <a href="{{ route('secretaire.demandes') }}" class="text-blue-600 hover:text-blue-800 text-sm">
            Voir plus <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>
    
    <div class="p-6">
        @if($recentes_demandes->count() > 0)
            <div class="space-y-4">
                @foreach($recentes_demandes as $demande)
                    <div class="border-l-4 border-blue-500 pl-4 py-2">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-medium text-gray-800">{{ $demande->demandeur }}</p>
                                <p class="text-sm text-gray-600">{{ Str::limit($demande->intentions, 50) }}</p>
                                <p class="text-xs text-gray-500 mt-1">
                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded">{{ $demande->type_messe }}</span>
                                </p>
                            </div>
                            <span class="text-sm text-gray-500">{{ $demande->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center py-4">Aucune demande récente</p>
        @endif
    </div>
</div>
@endsection
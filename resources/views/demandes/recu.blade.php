@extends('layout')

@section('title', 'Reçu de Demande')
@section('page-title', 'Reçu de Demande de Messe')

@section('content')
@php
    use Carbon\Carbon;
@endphp
<div class="bg-white rounded-lg shadow p-8 max-w-2xl mx-auto" id="recu">
    <div class="text-center mb-8">
         <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-20 h-20 mx-auto">
        <h1 class="text-2xl font-bold text-gray-800">Reçu de Demande de Messe</h1>
        <p class="text-gray-600">Numéro: {{ $demande->numero_recu }}</p>
    </div>

    <div class="grid grid-cols-2 gap-4 mb-8">
        <div>
            <p class="text-sm text-gray-600">Demandeur:</p>
            <p class="font-medium">{{ $demande->demandeur }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-600">Date de demande:</p>
            <p class="font-medium">{{ Carbon::parse($demande->created_at)->format('d/m/Y H:i') }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-600">Type de messe:</p>
            <p class="font-medium">{{ $demande->type_messe }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-600">Date de célébration:</p>
            <p class="font-medium">{{ Carbon::parse($demande->date_celebration)->format('d/m/Y') }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-600">Heure:</p>
            <p class="font-medium">{{ $demande->heure_celebration }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-600">Montant payé:</p>
            <p class="font-medium text-green-600">{{ number_format($demande->montant_paye, 0, ',', ' ') }} FCFA</p>
        </div>
    </div>

    <div class="mb-8">
        <p class="text-sm text-gray-600 mb-2">Intentions:</p>
        <p class="bg-gray-50 p-4 rounded">{{ $demande->intentions }}</p>
    </div>

    <div class="text-center text-sm text-gray-600 mt-12 pt-6 border-t">
        <p>Merci pour votre confiance</p>
        <p class="mt-2">Ce reçu est valable comme preuve de paiement</p>
    </div>

    <div class="mt-8 text-center">
        <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
            <i class="fas fa-print mr-2"></i>Imprimer le reçu
        </button>
    </div>
</div>

<style>
@media print {
    body * {
        visibility: hidden;
    }
    #recu, #recu * {
        visibility: visible;
    }
    #recu {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        box-shadow: none;
        margin: 0;
        padding: 20px;
    }
    button {
        display: none !important;
    }
}
</style>
@endsection
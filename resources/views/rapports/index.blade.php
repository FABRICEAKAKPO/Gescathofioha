@extends('layout')

@section('title', 'Rapports')
@section('page-title', 'Rapports')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <a href="{{ route('rapports.intentions') }}" 
       class="bg-white rounded-lg shadow-lg p-8 hover:shadow-xl transition transform hover:scale-105">
        <div class="flex items-center space-x-4">
            <div class="bg-blue-100 rounded-full p-4">
                <i class="fas fa-pray text-blue-600 text-3xl"></i>
            </div>
            <div>
                <h3 class="text-xl font-semibold text-gray-800">Rapport des Intentions</h3>
                <p class="text-gray-600">Liste des intentions par date de célébration</p>
            </div>
        </div>
    </a>

    <a href="{{ route('rapports.caisse') }}" 
       class="bg-white rounded-lg shadow-lg p-8 hover:shadow-xl transition transform hover:scale-105">
        <div class="flex items-center space-x-4">
            <div class="bg-green-100 rounded-full p-4">
                <i class="fas fa-chart-bar text-green-600 text-3xl"></i>
            </div>
            <div>
                <h3 class="text-xl font-semibold text-gray-800">Rapport de Caisse</h3>
                <p class="text-gray-600">Récapitulatif des recettes et dépenses</p>
            </div>
        </div>
    </a>
</div>
@endsection
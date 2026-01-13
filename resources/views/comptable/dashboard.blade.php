@extends('layout')

@section('title', 'Tableau de Bord - Comptable')
@section('page-title', 'Tableau de Bord - Comptable')

@section('content')
@php use App\Models\Recette; use App\Models\Depense; @endphp
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <!-- Recettes du mois -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Recettes du mois</p>
                <h3 class="text-3xl font-bold text-green-600">{{ number_format($stats['recettes_mois'], 0, ',', ' ') }} FCFA</h3>
            </div>
            <div class="bg-green-100 rounded-full p-3">
                <i class="fas fa-money-bill-wave text-green-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Dépenses du mois -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Dépenses du mois</p>
                <h3 class="text-3xl font-bold text-red-600">{{ number_format($stats['depenses_mois'], 0, ',', ' ') }} FCFA</h3>
            </div>
            <div class="bg-red-100 rounded-full p-3">
                <i class="fas fa-money-bill text-red-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Solde du mois -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Solde du mois</p>
                <h3 class="text-3xl font-bold {{ $stats['solde_mois'] >= 0 ? 'text-blue-600' : 'text-red-600' }}">{{ number_format($stats['solde_mois'], 0, ',', ' ') }} FCFA</h3>
            </div>
            <div class="bg-blue-100 rounded-full p-3">
                <i class="fas fa-balance-scale text-blue-600 text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Accès rapide -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Accès rapide</h3>
        <div class="space-y-3">
            <a href="{{ route('comptable.recettes') }}" class="flex items-center p-3 bg-blue-50 rounded-lg hover:bg-blue-100">
                <i class="fas fa-money-bill-wave text-blue-600 mr-3"></i>
                <span>Gestion des Recettes</span>
            </a>
            <a href="{{ route('comptable.depenses') }}" class="flex items-center p-3 bg-red-50 rounded-lg hover:bg-red-100">
                <i class="fas fa-money-bill text-red-600 mr-3"></i>
                <span>Gestion des Dépenses</span>
            </a>
            <a href="{{ route('comptable.rapports.caisse') }}" class="flex items-center p-3 bg-green-50 rounded-lg hover:bg-green-100">
                <i class="fas fa-chart-bar text-green-600 mr-3"></i>
                <span>Rapports Financiers</span>
            </a>
            <a href="{{ route('comptable.suivi-paiements') }}" class="flex items-center p-3 bg-purple-50 rounded-lg hover:bg-purple-100">
                <i class="fas fa-file-invoice-dollar text-purple-600 mr-3"></i>
                <span>Suivi des Paiements</span>
            </a>
        </div>
    </div>

    <!-- Résumé financier -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Résumé financier</h3>
        <div class="space-y-4">
            <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                <span>Total Recettes</span>
                <span class="font-semibold text-green-600">{{ number_format(Recette::sum('montant'), 0, ',', ' ') }} FCFA</span>
            </div>
            <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                <span>Total Dépenses</span>
                <span class="font-semibold text-red-600">{{ number_format(Depense::sum('montant'), 0, ',', ' ') }} FCFA</span>
            </div>
            <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                <span>Solde global</span>
                <span class="font-semibold {{ Recette::sum('montant') - Depense::sum('montant') >= 0 ? 'text-blue-600' : 'text-red-600' }}">{{ number_format(Recette::sum('montant') - Depense::sum('montant'), 0, ',', ' ') }} FCFA</span>
            </div>
        </div>
    </div>
</div>
@endsection
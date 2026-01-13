@extends('layout')

@section('title', 'Dashboard')
@section('page-title', 'Tableau de Bord')

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

    <!-- Paiements du jour -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Paiements du jour</p>
                <h3 class="text-3xl font-bold text-green-600">{{ number_format($stats['paiements_jour'], 0, ',', ' ') }} FCFA</h3>
            </div>
            <div class="bg-green-100 rounded-full p-3">
                <i class="fas fa-money-bill-wave text-green-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Messes demain -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Messes à célébrer demain</p>
                <h3 class="text-3xl font-bold text-purple-600">{{ $stats['messes_demain'] }}</h3>
            </div>
            <div class="bg-purple-100 rounded-full p-3">
                <i class="fas fa-church text-purple-600 text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Récentes demandes -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold">Récentes Demandes de Messe</h3>
            <a href="{{ route('demandes.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">
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

    <!-- Calendrier -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold">Calendrier</h3>
            <div class="flex space-x-2">
                <a href="{{ route('dashboard') }}?mois={{ $dateCourante->copy()->subMonth()->month }}&annee={{ $dateCourante->copy()->subMonth()->year }}" 
                   class="text-gray-600 hover:text-blue-600">
                    <i class="fas fa-chevron-left"></i>
                </a>
                <a href="{{ route('dashboard') }}?mois={{ $dateCourante->copy()->addMonth()->month }}&annee={{ $dateCourante->copy()->addMonth()->year }}" 
                   class="text-gray-600 hover:text-blue-600">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </div>
        </div>
        <div class="p-6">
            <div id="calendar" class="text-center">
                <div class="mb-4">
                    <h4 class="text-xl font-semibold">{{ $dateCourante->translatedFormat('F Y') }}</h4>
                </div>
                <div class="grid grid-cols-7 gap-2 text-center">
                    <div class="font-semibold text-gray-600">Lun</div>
                    <div class="font-semibold text-gray-600">Mar</div>
                    <div class="font-semibold text-gray-600">Mer</div>
                    <div class="font-semibold text-gray-600">Jeu</div>
                    <div class="font-semibold text-gray-600">Ven</div>
                    <div class="font-semibold text-gray-600">Sam</div>
                    <div class="font-semibold text-red-600">Dim</div>
                    
                    @php
                        $startOfMonth = $dateCourante->copy()->startOfMonth();
                        $endOfMonth = $dateCourante->copy()->endOfMonth();
                        $startDay = $startOfMonth->dayOfWeek === 0 ? 6 : $startOfMonth->dayOfWeek - 1;
                        
                        for($i = 0; $i < $startDay; $i++) {
                            echo '<div></div>';
                        }
                        
                        for($day = 1; $day <= $endOfMonth->day; $day++) {
                            $currentDate = $dateCourante->copy()->day($day);
                            $isToday = $currentDate->isToday();
                            $isSunday = $currentDate->dayOfWeek === 0;
                            
                            $class = $isToday ? 'bg-blue-600 text-white' : ($isSunday ? 'text-red-600' : 'text-gray-700');
                            echo "<div class='p-2 rounded {$class} hover:bg-gray-100'>{$day}</div>";
                        }
                    @endphp
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
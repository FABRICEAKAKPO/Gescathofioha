<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Application')</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen flex">
    <!-- Sidebar -->
    <div class="bg-white shadow-md w-64 min-h-screen flex flex-col">
        <div class="p-4">
            <!-- <a href="{{ route('dashboard') }}" class="text-xl font-bold text-blue-600 block mb-8">Gescatho</a> -->
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-30 h-30 mx-auto">
        </div>
    
        <nav class="flex-1 mt-6">
            <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-blue-100 hover:text-blue-600">
                <i class="fas fa-tachometer-alt mr-3"></i>
                Tableau de bord
            </a>
            
    
            
            @auth
                @if(Auth::user()->role === 'admin')
            <a href="{{ route('demandes.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-blue-100 hover:text-blue-600">
                <i class="fas fa-pray mr-3"></i>
                Demandes
            </a>
            <a href="{{ route('recettes.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-blue-100 hover:text-blue-600">
                <i class="fas fa-coins mr-3"></i>
                Recettes
            </a>
            <a href="{{ route('depenses.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-blue-100 hover:text-blue-600">
                <i class="fas fa-hand-holding-usd mr-3"></i>
                Dépenses
            </a>
            <a href="{{ route('rapports.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-blue-100 hover:text-blue-600">
                <i class="fas fa-chart-bar mr-3"></i>
                Rapports
            </a>
                @elseif(Auth::user()->role === 'secretaire')
                @elseif(Auth::user()->role === 'comptable')
                @endif
            @endauth
            
            @auth
                @if(Auth::user()->role === 'admin')
                <a href="{{ route('users.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-blue-100 hover:text-blue-600">
                    <i class="fas fa-users mr-3"></i>
                    Gestion des Utilisateurs
                </a>
                @endif
            @endauth

             @auth
            <a href="{{ route('profile.edit') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-blue-100 hover:text-blue-600">
                <i class="fas fa-user mr-3"></i>
                Mon Profil
            </a>
            @endauth
            
            @auth
                @if(Auth::user()->role === 'secretaire')
                <!-- Menu pour le secrétaire -->
                <div class="mt-8">
                    <h3 class="px-6 text-sm font-semibold text-gray-500 uppercase tracking-wider">Secrétaire</h3>
                    <a href="{{ route('secretaire.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-blue-100 hover:text-blue-600">
                        <i class="fas fa-user-secret mr-3"></i>
                        Accueil Secrétaire
                    </a>
                    <a href="{{ route('secretaire.demandes') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-blue-100 hover:text-blue-600">
                        <i class="fas fa-praying-hands mr-3"></i>
                        Demandes
                    </a>
                    <a href="{{ route('secretaire.recettes') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-blue-100 hover:text-blue-600">
                        <i class="fas fa-coins mr-3"></i>
                        Recettes
                    </a>
                    <a href="{{ route('secretaire.depenses') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-blue-100 hover:text-blue-600">
                        <i class="fas fa-money-bill mr-3"></i>
                        Dépenses
                    </a>
                    <a href="{{ route('secretaire.rapports.intentions') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-blue-100 hover:text-blue-600">
                        <i class="fas fa-file-alt mr-3"></i>
                        Rapport Intentions
                    </a>
                </div>
                @elseif(Auth::user()->role === 'comptable')
                <!-- Menu pour le comptable -->
                <div class="mt-8">
                    <h3 class="px-6 text-sm font-semibold text-gray-500 uppercase tracking-wider">Comptable</h3>
                    <a href="{{ route('comptable.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-blue-100 hover:text-blue-600">
                        <i class="fas fa-calculator mr-3"></i>
                        Accueil Comptable
                    </a>
                    <a href="{{ route('comptable.recettes') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-blue-100 hover:text-blue-600">
                        <i class="fas fa-coins mr-3"></i>
                        Recettes
                    </a>
                    <a href="{{ route('comptable.depenses') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-blue-100 hover:text-blue-600">
                        <i class="fas fa-money-bill mr-3"></i>
                        Dépenses
                    </a>
                    <a href="{{ route('comptable.rapports.caisse') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-blue-100 hover:text-blue-600">
                        <i class="fas fa-chart-bar mr-3"></i>
                        Rapport Caisse
                    </a>
                    <a href="{{ route('comptable.suivi-paiements') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-blue-100 hover:text-blue-600">
                        <i class="fas fa-file-invoice-dollar mr-3"></i>
                        Suivi Paiements
                    </a>
                </div>
                @endif
            @endauth
        </nav>
        
        <!-- Footer with user info and logout in sidebar -->
        @auth
        <div class="bg-gray-800 text-white p-4 mt-auto">
            <div class="flex flex-col items-center">
                <span class="text-sm mb-2">Bienvenue, {{ Auth::user()->name }}</span>
                <span class="text-xs text-gray-300 mb-3">({{ ucfirst(Auth::user()->role) }})</span>
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-sm">
                        <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                    </button>
                </form>
            </div>
        </div>
        @endauth
    </div>

    <!-- Main Content -->
    <div class="flex-1">

        
        <main class="max-w-7xl mx-auto px-4 py-6">
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-800">@yield('page-title')</h1>
            </div>
            
            @yield('content')
        </main>
    </div>
    
</body>
</html>
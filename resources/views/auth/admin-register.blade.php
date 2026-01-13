<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création Compte Administrateur - Gescatho</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-red-600">Gescatho</h1>
            <p class="text-gray-600">Création du Compte Administrateur</p>
            <p class="text-sm text-red-500 mt-2">Cette opération ne peut être effectuée qu'une seule fois</p>
        </div>
        
        <form method="POST" action="{{ route('admin.register') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium mb-2" for="name">
                    Nom
                </label>
                <input type="text" name="name" id="name" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium mb-2" for="email">
                    Email
                </label>
                <input type="email" name="email" id="email" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium mb-2" for="password">
                    Mot de passe
                </label>
                <input type="password" name="password" id="password" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium mb-2" for="password_confirmation">
                    Confirmer le mot de passe
                </label>
                <input type="password" name="password_confirmation" id="password_confirmation" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required>
            </div>
            
            <div class="mb-6">
                <button type="submit" 
                        class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-md">
                    Créer le Compte Administrateur
                </button>
            </div>
        </form>
        
        <div class="text-center">
            <p class="text-gray-600 text-sm">
                <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800">
                    ← Retour à la connexion
                </a>
            </p>
        </div>
    </div>
</body>
</html>
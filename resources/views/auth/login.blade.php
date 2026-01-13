<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Gescatho</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #4f46e5, #3b82f6);
            background-size: 400% 400%;
            animation: gradientAnimation 15s ease infinite;
            position: relative;
            overflow: hidden;
        }

        @keyframes gradientAnimation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .line-animation {
            position: absolute;
            width: 2px;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            animation: moveLines 5s linear infinite;
        }

        @keyframes moveLines {
            from {
                transform: translateY(-100%);
            }
            to {
                transform: translateY(100%);
            }
        }

        .shape {
            position: absolute;
            width: 20px;
            height: 20px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            animation: moveShapes 10s linear infinite;
        }

        @keyframes moveShapes {
            from {
                transform: translateY(-100%) rotate(0deg);
            }
            to {
                transform: translateY(100%) rotate(360deg);
            }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-md w-full max-w-4xl flex flex-col md:flex-row">
        <!-- Section gauche : Description de la plateforme -->
        <div class="md:w-1/2 p-8 flex flex-col justify-center">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Gescatho" class="w-32 h-32 mx-auto mb-4">
            <h1 class="text-2xl font-bold text-gray-800 mb-4 text-center">Bienvenue sur Gescatho</h1>
            <p class="text-gray-600 mb-4 text-center">
                Une application web pensée pour soutenir la gestion paroissiale dans l’esprit de l’Église catholique.
            </p>
            <div class="p-4 bg-blue-50 rounded-md">
                <h3 class="text-lg font-semibold text-blue-800 mb-2">Aperçu du système</h3>
                <p class="text-sm text-gray-700 mb-2">
                    Gescatho est un outil complet pour gérer les demandes de messe, les recettes et les dépenses de votre paroisse.
                </p>
                <ul class="text-sm text-gray-600 list-disc list-inside">
                    <li>Gestion des demandes de messe</li>
                    <li>Suivi des recettes financières</li>
                    <li>Contrôle des dépenses</li>
                    <li>Rapports et analyses</li>
                </ul>
            </div>
        </div>
        
        <!-- Section droite : Formulaire de connexion -->
        <div class="md:w-1/2 p-8 flex flex-col justify-center">
            <div class="text-center mb-6">
                <p class="text-gray-600">Connexion à votre compte</p>
            </div>
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
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
                
                @if($errors->any())
                    <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                
                <div class="mb-6">
                    <button type="submit" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md">
                        Se connecter
                    </button>
                </div>
            </form>
            
            <div class="text-center">
                <p class="text-gray-600 text-sm">
                    Si vous êtes un personnel et que vous n'avez pas encore de compte :
                    <a href="https://wa.me/22892877153" class="text-red-600 hover:text-red-800 font-medium">
                        Contactez l'administrateur
                    </a>
                </p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const body = document.body;
            for (let i = 0; i < 50; i++) {
                const line = document.createElement('div');
                line.classList.add('line-animation');
                line.style.left = `${Math.random() * 100}vw`;
                line.style.animationDuration = `${Math.random() * 3 + 2}s`;
                body.appendChild(line);
            }

            for (let i = 0; i < 20; i++) {
                const shape = document.createElement('div');
                shape.classList.add('shape');
                shape.style.left = `${Math.random() * 100}vw`;
                shape.style.animationDuration = `${Math.random() * 5 + 5}s`;
                shape.style.opacity = Math.random();
                body.appendChild(shape);
            }
        });
    </script>
</body>
</html>
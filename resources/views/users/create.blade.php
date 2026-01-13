@extends('layout')

@section('title', 'Créer un Utilisateur')
@section('page-title', 'Créer un Utilisateur')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <form method="POST" action="{{ route('users.store') }}">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nom</label>
                <input type="text" name="name" required 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" name="email" required 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Mot de passe</label>
                <input type="password" name="password" required 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" required 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Rôle</label>
                <select name="role" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Sélectionnez un rôle</option>
                    <option value="admin">Administrateur</option>
                    <option value="secretaire">Secrétaire</option>
                    <option value="comptable">Comptable</option>
                </select>
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('users.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                Annuler
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Créer
            </button>
        </div>
    </form>
</div>
@endsection
@extends('layout')

@section('title', 'Modifier le profil')
@section('page-title', 'Modifier le profil')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-semibold mb-4">Modifier vos informations personnelles</h2>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-medium mb-2" for="name">
                Nom
            </label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                   required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-medium mb-2" for="email">
                Email
            </label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                   required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-medium mb-2" for="current_password">
                Mot de passe actuel (requis pour changer le mot de passe)
            </label>
            <input type="password" name="current_password" id="current_password"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-medium mb-2" for="password">
                Nouveau mot de passe (laisser vide pour ne pas changer)
            </label>
            <input type="password" name="password" id="password"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-medium mb-2" for="password_confirmation">
                Confirmer le nouveau mot de passe
            </label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="flex justify-end">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md">
                Mettre à jour
            </button>
        </div>
    </form>
</div>
@endsection
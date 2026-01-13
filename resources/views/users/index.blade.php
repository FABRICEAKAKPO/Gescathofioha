@extends('layout')

@section('title', 'Gestion des Utilisateurs')
@section('page-title', 'Gestion des Utilisateurs')

@section('content')
<div class="mb-6">
    <a href="{{ route('users.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
        <i class="fas fa-plus mr-2"></i>Ajouter un Utilisateur
    </a>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rôle</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($users as $user)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs rounded 
                            @if($user->role === 'admin') bg-red-100 text-red-800
                            @elseif($user->role === 'secretaire') bg-blue-100 text-blue-800
                            @else bg-green-100 text-green-800
                            @endif">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('users.edit', $user) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                            <i class="fas fa-edit"></i> Modifier
                        </a>
                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">
                                <i class="fas fa-trash"></i> Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">Aucun utilisateur trouvé</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
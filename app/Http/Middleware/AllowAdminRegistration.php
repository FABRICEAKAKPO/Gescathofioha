<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class AllowAdminRegistration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Autoriser l'inscription admin seulement si aucun utilisateur n'existe encore
        // ou si un paramètre spécial est fourni (pour les cas d'urgence)
        $userCount = User::count();
        
        // Autoriser l'inscription admin seulement si aucun utilisateur n'existe encore
        // ou si un paramètre spécial est fourni (pour les cas d'urgence)
        if ($userCount > 0 && (!$request->has('force') || $request->get('force') !== 'admin123')) {
            abort(403, 'L\'inscription administrateur n\'est plus autorisée. Veuillez contacter un administrateur existant pour créer des utilisateurs.');
        }

        return $next($request);
    }
}

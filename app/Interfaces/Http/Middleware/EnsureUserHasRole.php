<?php

namespace App\Interfaces\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'No autenticado.'], 401);
        }

        // $user es el UserModel de Eloquent (autenticado vía Sanctum);
        // 'role' se asume castead a UserRole enum o string plano en la tabla.
        $userRole = $user->role instanceof \App\Domain\User\ValueObjects\UserRole
            ? $user->role->value
            : $user->role;

        if (!in_array($userRole, $roles, true)) {
            return response()->json(['message' => 'No tiene permisos para acceder a este recurso.'], 403);
        }

        return $next($request);
    }
}
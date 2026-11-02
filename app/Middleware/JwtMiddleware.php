<?php

namespace App\Middleware;

use App\Services\JwtService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JwtMiddleware
{
    protected JwtService $jwtService;

    public function __construct(JwtService $jwtService)
    {
        $this->jwtService = $jwtService;
    }

    public function handle(Request $request, Closure $next): Response
    {
        $authHeader = $request->header('Authorization');

        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return response()->json([
                'success' => false,
                'message' => 'Jeton d\'authentification manquant ou invalide.',
            ], 401);
        }

        $token = substr($authHeader, 7);
        $user = $this->jwtService->getUserFromToken($token);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Session expirée ou jeton JWT non valide. Veuillez vous reconnecter.',
            ], 401);
        }

        // Attach user to request
        $request->setUserResolver(fn() => $user);

        return $next($request);
    }
}

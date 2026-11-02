<?php

namespace App\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || $user->role !== 'admin') {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Accès refusé. Privilèges administrateur requis.',
                ], 403);
            }

            return redirect()->route('admin.login')->with('error', 'Accès réservé aux administrateurs de la plateforme.');
        }

        return $next($request);
    }
}

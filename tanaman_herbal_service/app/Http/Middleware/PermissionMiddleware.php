<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = Auth::user();

        // Jika user tidak ada atau tidak memiliki salah satu role yang diizinkan, tolak akses
        if (! $user || ! $user->hasAnyRole($roles)) {
            return response()->json([
                "status_code" => 403,
                "message"     => "Access denied. Only " . implode(',', $roles) . " allowed.",
            ], 403);
        }

        return $next($request);
    }
}

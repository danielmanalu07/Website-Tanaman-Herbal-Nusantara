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
    public function handle(Request $request, Closure $next, $role, $permission = null): Response
    {
        $user = Auth::user();

        if (! $user || ! $user->hasRole($role)) {
            return response()->json([
                "status_code" => 403,
                "message"     => "Access denied. $role only.",
            ], 403);
        }

        if ($permission && ! $user->can($permission)) {
            return response()->json([
                "status_code" => 403,
                "message"     => "Access denied. You don't have permission for $permission.",
            ], 403);
        }

        return $next($request);
    }
}

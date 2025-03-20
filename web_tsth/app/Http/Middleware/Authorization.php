<?php
namespace App\Http\Middleware;

use App\Http\Constant\TokenConstant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = TokenConstant::GetToken();
        if (is_null($token)) {
            return redirect()->route('admin.login')->with('error', 'You must be logged in.');
        }
        return $next($request);
    }
}

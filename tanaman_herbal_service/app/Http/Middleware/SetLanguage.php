<?php
namespace App\Http\Middleware;

use App\Models\Language;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $langCode = $request->header('Accept-Language', 'id'); // Default 'id'

        $language = Language::where('code', $langCode)->first();

        if (! $language) {
            $language = Language::where('code', 'id')->first(); // fallback
        }

        // Simpan ke app() agar bisa diambil dari mana saja
        app()->instance('current_language', $language);
        return $next($request);
    }
}

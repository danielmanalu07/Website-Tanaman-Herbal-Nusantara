<?php
namespace App\Http\Middleware;

use App\Http\Constant\LanguageConstant;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class SetAcceptLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $language = LanguageConstant::GetLanguage();

        Http::macro('language', function () use ($language) {
            return Http::withHeaders([
                'Accept-Language' => $language,
            ]);
        });
        return $next($request);
    }
}

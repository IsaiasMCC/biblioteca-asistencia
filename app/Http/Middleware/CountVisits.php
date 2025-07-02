<?php

namespace App\Http\Middleware;

use App\Models\PageVisit;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CountVisits
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $currentPage = $request->path();
        
        // Busca o crea un registro para la página actual
        $pageVisit = PageVisit::firstOrCreate(['page' => $currentPage]);
        $pageVisit->increment('visits');
        return $next($request);
    }
}

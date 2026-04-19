<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->header('API-Key');
        $validKey = env('API_KEY');

        if ($apiKey !== $validKey) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid API Key'
            ], 401);
        }

        return $next($request);
    }
}

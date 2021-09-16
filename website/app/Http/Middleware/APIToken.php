<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class APIToken
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
        $token = $request->bearerToken();
        if ($token == '') {
            return $next($request);
        }
        else {
        return response([
            'message' => 'Błąd autoryzacji.'
        ], 403);
        }
    }
}

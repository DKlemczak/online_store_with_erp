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
        if ($token == 'schKd2FYUG5iMkpwYkc1NU1qQxhPQT09O8luexduaWVya2CyMzs3NTtTZXJ2addlX2UycjBwMWk4dDsyMDE4LTA2LTE8IciSAjQzAAAwO3Rlc3RlDjNAXmdqLXNvZnQuccdc') {
            return $next($request);
        }
        else {
        return response([
            'message' => 'Błąd autoryzacji.'
        ], 403);
        }
    }
}

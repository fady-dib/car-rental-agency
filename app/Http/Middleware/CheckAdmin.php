<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('admin')->check()) {
            return $next($request);
        }

        $error = [
            'error' => [
                'debugger' => 'Unauthorized',
                'code' => 101,
                'message' => 'Unauthorized'
            ],
        ];
        
        return response()->json($error,401);
    }
}

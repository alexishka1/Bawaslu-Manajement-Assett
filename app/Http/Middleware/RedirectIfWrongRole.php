<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfWrongRole
{
    /**
     * Handle an incoming request.
     *
     * @param  string  $requiredRole  'admin' atau 'staff'
     */
    public function handle(Request $request, Closure $next, string $requiredRole): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        if ($user->role !== $requiredRole) {
            return redirect($user->homeUrl())
                ->with('warning', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        return $next($request);
    }
}

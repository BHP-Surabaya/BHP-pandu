<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        $authorized = $user && (
            in_array($user->role, $roles, true)
            || (in_array('kurator_madya', $roles, true) && $user->isKuratorMadya())
            || (in_array('kurator_muda', $roles, true) && $user->isKuratorMuda())
            || ((in_array('petugas', $roles, true) || in_array('kurator_pertama', $roles, true)) && $user->isKuratorPertama())
        );

        abort_unless($authorized, 403);

        return $next($request);
    }
}

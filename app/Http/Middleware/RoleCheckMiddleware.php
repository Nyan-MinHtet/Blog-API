<?php

namespace App\Http\Middleware;

use App\Http\Helpers\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleCheckMiddleware
{
    use ApiResponse;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = Auth::user();
        if ($user && in_array($user->role , $roles)) {
            return $next($request);
        }
        return $this->errorResponse(
            "You can't access this route!",
            403
        );
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Helpers\ApiResponse;
use Error;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SuspendCheckMiddleware
{
    use ApiResponse;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->routeIs('auth.login')) {
            $user = User::where('email', $request->email)->first();
            if ($this->suspensionCheck($user)) {
                return $this->errorResponse('Your account is being suspended!', 403);
            }
        }else{
            $user = Auth::user();
            if ($this->suspensionCheck($user)) {
                abort(message: 'Your account is being suspended!',code: 403);
            }
        }
        return $next($request);
    }
    private function suspensionCheck($user){
        if($user->status === 'Suspended') {
            return true;
        }
    }
}

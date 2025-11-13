<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponseTrait;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    use ApiResponseTrait;

    public function handle(Request $request, Closure $next): Response
    {

        $user = request()->user("sanctum");
        if ($user->role !== "admin") {
            return $this->forbidden();
        }

        return $next($request);
    }
}

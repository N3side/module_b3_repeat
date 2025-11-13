<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponseTrait;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIsUser
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

        if (!$user) {
            return $this->forbidden();
        }

        return $next($request);
    }
}

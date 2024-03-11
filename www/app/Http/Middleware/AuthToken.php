<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->header("token") !== "") {
            if (User::query()->where("remember_token", $request->header("token"))->first()) {
                return $next($request);
            }
        }
        return response()->json(["message" => "bad request!"], 401);
    }
}

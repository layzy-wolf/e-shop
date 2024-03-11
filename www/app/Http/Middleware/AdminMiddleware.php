<?php

namespace App\Http\Middleware;

use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AdminMiddleware
{
    public function handle(Request $request, \Closure $next)
    {
        if (isset($request->user()->id) && $request->user()->admin) {
            return $next($request);
        }
        return redirect()->route("admin.auth");
    }

    private function verifyUserByToken(string $token): bool
    {
        if (User::query()
            ->where("remember_token", $token)
            ->first()
            ->admin
        ) return true;
        return false;
    }
}

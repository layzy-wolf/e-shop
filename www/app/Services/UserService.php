<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;

class UserService
{
    public static function generateToken()
    {
        while (true) {
            $token = Str::random(100);

            if (User::query()->where("remember_token", $token)->first()) {
                continue;
            } break;
        }
        return $token;
    }

    public static function updateToken(User $user)
    {
        $token = UserService::generateToken();
        if ($user->remember_token) {
            BasketService::updateToken($user->remember_token, $token);
        }
        $user->remember_token = $token;
        $user->save();
        return $user;
    }
}

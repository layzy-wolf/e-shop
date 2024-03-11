<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidateUserTokenException;
use App\Models\User;
use App\Services\BasketService;
use App\Services\UserService;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        try {
            $user = User::query()->create([
                "email" => $request->email,
                "name" => $request->name,
                "password" => $request->password,
            ]);

            $status = 200;
            $message = "register done!";
        } catch (QueryException $ex) {
            $status = 401;
            $message = $ex->getMessage();
        }

        return response()->json(["message" => $message], $status);
    }

    public function login(Request $request): JsonResponse
    {
        $user = User::query()
            ->where("email", $request->email)
            ->first();

        if (Hash::check($request->password, $user->password)) {
            if (UserService::updateToken($user)) {
                $status = 200;
                $message = "login done!";
            } else {
                $message = "bad request";
                $status = 401;
            }
        } else {
            $status = 401;
            $message = "bad request";
        }


        return response()->json([
            "message" => $message,
            "token" => $user->remember_token ?? "",
        ], $status);
    }

    public function logout(Request $request): JsonResponse
    {
        $body = Json::decode($request->body());

        $user = User::query()
            ->where("email", $body->email)
            ->where("remember_token", $body->remember_token)
            ->first();

        if (isset($user)) {
            $user->remember_token = "";
            $user->save();

            $status = 200;
            $message = "logout done!";
        } else {
            $status = 401;
            $message = "bad request";
        }

        return response()->json(["message" => $message], $status);
    }

    public function view()
    {
        return view("admin.users", ["users" => User::all()]);
    }

    public static function getUser(string $token): Model|string
    {
        $user = User::query()->where("remember_token", $token)->first();
        if (isset($user)) {
            return $user;
        }
        throw new InvalidateUserTokenException();
    }
}

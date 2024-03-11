<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Models\Order;
use App\Services\BasketService;
use App\Services\UserService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function show(Request $request)
    {
        $user = (new BasketService)->getUser($request->header("token"));

        $orders = Order::query()->where("user_id", $user->id)->with("basket", function ($q) {
            $q->with("products");
        })->get();

        foreach ($orders as $order) {
            $order->products = $order->basket->products;
            foreach ($order->products as $product) {
                $product->price = $product->pivot->price;
                $product->amount = $product->pivot->amount;
                unset($product->description, $product->category_id, $product->pivot, $product->created_at, $product->updated_at);
            }
            unset($order->basket, $order->created_at, $order->updated_at);
        }

        return response()->json(["orders" => $orders], 200);
    }

    public function make(Request $request)
    {
        $token = $request->header("token");

        $basket = BasketService::getBasket($token);

        if (!isset($basket)) {
            return response()->json(["error" => "bad request"], 403);
        }

        $user = (new BasketService)->getUser($token);

        Order::query()->create([
            "user_id" => $user->id,
            "basket_id" => $basket->id,
            "status" => StatusEnum::ASSEMBLING->value,
        ]);
        UserService::updateToken($user);

        return response()->json(["message" => "order done!", "token" => $user->remember_token], 200);
    }
}

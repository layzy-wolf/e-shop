<?php

namespace App\Services;

use App\Exceptions\InvalidateUserTokenException;
use App\Http\Controllers\UserController;
use App\Models\Basket;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class BasketService
{
    public function getUser(string $token): User|string
    {
        return UserController::getUser($token);
    }

    public function revoke(User $user)
    {
        return Basket::query()->doesntHave("order")->firstOrCreate([
            "basket_token" => $user->remember_token,
        ]);
    }

    public function getProductsOfBasket(Basket $basket)
    {
        return Basket::where("id", $basket->id)->with("products", function ($builder) use ($basket) {
            $builder->where("basket_id", $basket->id);
        })->first()->products;
    }

    public function syncBasket(Basket $basket, array $products)
    {
        $basket->products()->detach();
        foreach ($products as $product) {
            $basket->products()->attach([
                $product["id"] => [
                    "amount" => $product["amount"],
                    "price" => Product::find($product["id"])->price,
                ],
            ]);
        }
    }

    public static function updateToken(string $oldToken, string $newToken)
    {
        $basketService = new self;
        $basket = $basketService->revoke($basketService->getUser($oldToken));
        return (bool)$basket->update(["basket_token", $newToken]);
    }

    public static function getBasket(string $token)
    {
        return Basket::query()->where("basket_token", $token)->first();
    }
}

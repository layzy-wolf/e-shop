<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidateUserTokenException;
use App\Models\Product;
use App\Services\BasketService;
use Illuminate\Http\Request;

class BasketController extends Controller
{
    private BasketService $basketService;

    public function __construct(BasketService $basketService)
    {
        $this->basketService = $basketService;
    }

    public function sync(Request $request)
    {
        $token = $request->header("token");

        $basket = $this->basketService->revoke($this->basketService->getUser($token));

        if ($request->rewrite) {
            $this->basketService->syncBasket($basket, $request->products);
        }

        $products = $this->basketService->getProductsOfBasket($basket);

        foreach ($products as $product) {
            $product->price = $product->pivot->price;
            $product->amount = $product->pivot->amount;
            unset($product->pivot, $product->description, $product->category_id, $product->created_at, $product->updated_at);
        }
        return response()->json(["products" => $products->toArray()], 200);
    }
}

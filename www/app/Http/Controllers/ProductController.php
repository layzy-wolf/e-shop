<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\Mime\Part\File;

class ProductController extends Controller
{
    public function view()
    {
        return view("admin.products", ["products" => Product::all(), "categories" => Category::all()]);
    }

    public function index()
    {
        $products = Product::all();
        foreach ($products as $product) {
            $product = $this->prepareProduct($product);
        }
        return response()->json($products, 200);
    }

    public function show(Product $product)
    {
        $product = $this->prepareProduct($product);
        return response()->json($product, 200);
    }

    public function create(Request $request)
    {
        $fileContent = base64_decode(explode(",", $request->img)[1]);
        $fileName = Str::random(32) . ".jpg";

        Storage::disk("public")->put($fileName, $fileContent);

        Product::query()->create([
            "name" => $request->name,
            "description" => $request->description,
            "price" => $request->price,
            "category_id" => $request->category,
            "img" => "public/" . $fileName,
        ]);

        return response()->json(["message" => "congrats"], 200);
    }

    public function update(Product $product, Request $request)
    {
        if (isset($request->file)) {
            Storage::disk("public")->put(explode("/", $product->img)[1], $request->file("file")->getContent());
        };

        Product::query()->find($product->id)->update([
            "name" => $request->name,
            "description" => $request->description,
            "price" => $request->price,
            "category_id" => $request->category,
        ]);

        return redirect()->back();
    }

    public function delete(Product $product)
    {
        Storage::disk("public")->delete(explode("/", $product->img)[1]);
        $product->delete();
        return redirect()->back();
    }

    private function prepareProduct(Product $product) {
        $product->img = "storage/". explode("/", $product->img)[1];
        $product->category_name = $product->category->name;
        unset($product->category, $product->category_id, $product->created_at, $product->updated_at);
        return $product;
    }
}

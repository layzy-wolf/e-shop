<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function view()
    {
        return view("admin.categories", ["categories" => Category::all()]);
    }

    public function create(Request $request)
    {
        Category::query()->create([
            "name" => $request->name,
            "category_id" => $request->category_id
        ]);

        return response()->json(["message" => "congrats"], 200);
    }

    public function update(Category $category, Request $request)
    {
        Category::query()->find($category->id)->update([
            "name" => $request->name,
            "category_id" => $request->category
        ]);
        return redirect()->back();
    }

    public function delete(Category $category)
    {
        $category->delete();

        return redirect()->back();
    }
}

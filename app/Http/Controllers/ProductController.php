<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;

class ProductController extends Controller
{
    public function getAll(): Collection
    {
        return Product::with("categories")->get();
    }

    public function get(Request $request): JsonResponse
    {
        $data = $request->validate([
            "id" => "nullable|int",
            "name" => "nullable|string",
            "price" => "nullable|int",
            "description" => "nullable|string"
        ]);

        $products = $this->getAll();

        if (isset($data["id"])) {
            $products = $products->where("id", $data["id"]);
        }

        if (isset($data["name"])) {
            $products = $products->where("name", $data["name"]);
        }

        if (isset($data["price"])) {
            $products = $products->where("price", $data["price"]);
        }

        if (isset($data["description"])) {
            $products = $products->where("description", $data["description"]);
        }

        return response()->json(
            $products
        );
    }

    public function post(Request $request): Application|ResponseFactory|Response
    {
        $data = $request->validate([
            "name" => "required|string",
            "price" => "required|numeric",
            "description" => "required|string"
        ]);

        $newProduct = Product::create([
            "name" => $data["name"],
            "price" => $data["price"],
            "description" => $data["description"]
        ]);

        // Product exists -> was created
        if ($newProduct) {
            // Created
            return response(status: 201);
        }

        // Bad Request
        return response(status: 400);
    }

    public function put(Request $request): Response|Application|ResponseFactory
    {
        $data = $request->validate([
            "id" => "required|int",
            "name" => "nullable|string",
            "price" => "nullable|int",
            "description" => "nullable|string"
        ]);

        $product = Product::find($data["price"]);

        if (!$product) {
            // Gone
            return response(status: 410);
        }

        if (isset($data["name"])) {
            $product->name = $data["name"];
        }

        if (isset($data["price"])) {
            $product->price = $data["price"];
        }

        if (isset($data["description"])) {
            $product->description = $data["description"];
        }

        $product->save();

        // Ok
        return response(status: 200);
    }

    public function delete(Request $request): Response|Application|ResponseFactory
    {
        $data = $request->validate([
            "id" => "required|int"
        ]);

        $deleted = Product::destroy($data["id"]) !== 0;

        if ($deleted) {
            // Ok
            return response(status: 200);
        }

        // Gone
        return response(status: 410);
    }

    public function assignCategory(Request $request): Response|Application|ResponseFactory
    {
        $data = $request->validate([
            "product" => "required|int",
            "category" => "required|int"
        ]);

        $product = Product::findOrFail($data["product"]);
        $category = Category::findOrFail($data["category"]);

        $product->categories()->attach($category->id);

        // Ok
        return response(status: 200);
    }

    public function unAssignCategory(Request $request): Response|Application|ResponseFactory
    {
        $data = $request->validate([
            "product" => "required|int",
            "category" => "required|int"
        ]);

        $product = Product::findOrFail($data["product"]);
        $category = Category::findOrFail($data["category"]);

        $product->categories()->detach($category->id);

        // Ok
        return response(status: 200);
    }
}

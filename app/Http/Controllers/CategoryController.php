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

class CategoryController extends Controller
{
    public function getAll(): Collection
    {
        return Category::with("relatedProducts")->get();
    }

    public function get(Request $request): JsonResponse
    {
        $data = $request->validate([
            "name" => "nullable|string"
        ]);

        $categories = $this->getAll();

        if (isset($data["name"])) {
            $categories->where("name", $data["name"]);
        }

        return response()->json(
            $categories
        );
    }

    public function post(Request $request): Response|Application|ResponseFactory
    {
        $data = $request->validate([
            "name" => "required|string"
        ]);

        $newCategory = Category::create([
            "name" => $data["name"]
        ]);

        // Category exists -> was created
        if ($newCategory) {
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
            "name" => "nullable|string"
        ]);

        $category = Category::findOrFail($data["id"]);

        if (isset($data["name"])) {
            $category->name = $data["name"];
        }
        $category->save();

        // Ok
        return response(status: 200);
    }

    public function delete(Request $request): Response|Application|ResponseFactory
    {
        $data = $request->validate([
            'id' => 'required|int'
        ]);

        $deleted = Category::destroy($data['id']) !== 0;

        if ($deleted) {
            // Ok
            return response(status: 200);
        }

        // Gone
        return response(status: 410);
    }
}

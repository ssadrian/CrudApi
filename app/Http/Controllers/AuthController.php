<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
    {
        $data = $request->validate([
            "name" => "required|string|unique:users",
            "email" => "required|string|email|unique:users",
            "password" => "required|string|min:8"
        ]);

        if (empty($data)) {
            return response("Empty");
        }

        $user = new User([
            "name" => $data["name"],
            "email" => $data["email"],
            "password" => Hash::make($data["password"])
        ]);
        $user->save();

        // Created
        return response(status: 201);
    }

    public function login()
    {

    }

    public function logout()
    {

    }
}

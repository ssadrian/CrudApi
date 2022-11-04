<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            "name" => "required|string|unique:users",
            "email" => "required|string|email|unique:users",
            "password" => "required|string|min:8"
        ]);
    }

    public function login()
    {

    }

    public function logout()
    {

    }
}

<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function login() {
        $validator = validator(request()->all(), [
            "email" => "required|email",
            "password" => "required|string|min:3",
        ]);

        if ($validator->fails()) return back()->withInput()->withErrors($validator->errors());

        $data = $validator->validated();

        if (!Auth::attempt($data)) return back()->withInput()->with(["toast" => "Login failed"]);

        $user = Auth::user();

        return redirect()->route("admin.index"); // это на index функцию редирект блять как ты забыл
    }

    public function logout() {
        \auth()->logout();

        return back()->with(["toast" => "Вы успешно вышли из системы"]);
    }

    public function index() {
        return view("pages/index");
    }
}

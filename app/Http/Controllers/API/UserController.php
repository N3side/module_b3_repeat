<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    use ApiResponseTrait;

    public function register() {
        $validator = validator(request()->all(), [
            "first_name" => "required|string",
            "last_name" => "required|string",
            "patronymic" => "required|string",
            "email" => "required|email|unique:users,email",
            "password" => "required|string|min:3",
            "birth_date" => "required|string"
        ]);

        if ($validator->fails()) return $this->validation(errors: $validator->errors());

        $data = $validator->validated();

        $user = User::create($data);

        return response()->json([
            "message" => "Пользователь создан",
            "code" => 201,
            "user" => UserResource::make($user)
        ], 201);
    }

    public function login() {
        $validator = validator(request()->all(), [
            "email" => "required|email",
            "password" => "required|string|min:3",
        ]);

        if ($validator->fails()) return $this->validation(errors: $validator->errors());

        $data = $validator->validated();

        if (!Auth::attempt($data)) return $this->loginfailed();

        $user = Auth::user();

        $token = $user->createToken("auth-token")->plainTextToken;

        return response()->json([
            "data" => [
                "user" => UserResource::make($user),
                "token" => $token
            ]
        ]);
    }

    public function logout() {
        $user = request()->user("sanctum");
        $user->tokens()->delete();

        return response()->json([

        ], 204);
    }

    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

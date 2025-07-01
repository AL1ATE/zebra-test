<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @group Auth
     *
     * Регистрация нового пользователя
     *
     * Зарегистрировать нового пользователя и вернуть его данные.
     *
     * @bodyParam name string required Имя пользователя. Example: John Doe
     * @bodyParam email string required Email. Example: john@example.com
     * @bodyParam password string required Пароль. Example: password
     *
     * @response 201 scenario="Успешно" {
     *  "id": 1,
     *  "name": "John Doe",
     *  "email": "john@example.com",
     *  "created_at": "2025-07-01T12:00:00Z",
     *  "updated_at": "2025-07-01T12:00:00Z"
     * }
     */
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json($user, 201);
    }

    /**
     * @group Auth
     *
     * Авторизация пользователя
     *
     * Вернуть токен для аутентифицированного пользователя.
     *
     * @bodyParam email string required Email пользователя. Example: john@example.com
     * @bodyParam password string required Пароль. Example: password
     *
     * @response 200 scenario="Успешно" {
     *  "token": "eyJ..."
     * }
     */
    public function login(LoginRequest $request)
    {
        $validated = $request->validated();

        $user = User::where('email', $validated['email'])->first();

        if (! $user || ! Hash::check($validated['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json(['token' => $token]);
    }
}

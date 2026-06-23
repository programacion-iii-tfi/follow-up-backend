<?php

namespace App\Interfaces\Http\User\Controllers;

use App\Application\User\DTOs\LoginUserDTO;
use App\Application\User\UseCases\LoginUserUseCase;
use App\Interfaces\Http\Controller;
use App\Interfaces\Http\User\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        private readonly LoginUserUseCase $loginUserUseCase
    ) {}

    public function login(LoginRequest $request): JsonResponse
    {
        $dto    = LoginUserDTO::fromArray($request->validated());
        $result = $this->loginUserUseCase->execute($dto);

        return response()->json([
            'token' => $result['token'],
            'rol'  => $result['rol'],
        ], 200);
    }

    // public function logout(): JsonResponse
    // {
    //     /** @var \App\Infrastructure\User\Persistence\UserModel $user */
    //     $user = auth()->user();
        
    //     $user->currentAccessToken()->delete();

    //     return response()->json(['message' => 'Sesión cerrada correctamente.'], 200);
    // }
}
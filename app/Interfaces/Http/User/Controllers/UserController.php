<?php

namespace App\Interfaces\Http\User\Controllers;

use App\Interfaces\Http\Controller;
use App\Application\User\UseCases\CreateUserUseCase;
use Illuminate\Http\JsonResponse;
use App\Application\User\DTOs\CreateUserDTO;
use App\Interfaces\Http\User\Resources\UserResource;
use App\Interfaces\Http\User\Requests\CreateUserRequest;
use App\Application\User\UseCases\GetAllUsersUseCase;

class UserController extends Controller
{
    public function __construct(
        private readonly CreateUserUseCase  $createUserUseCase,
        private readonly GetAllUsersUseCase $getAllUsersUseCase,
    ) {}

    public function store(CreateUserRequest $request): JsonResponse
    {
        $dto  = CreateUserDTO::fromArray($request->validated());
        $user = $this->createUserUseCase->execute($dto);

        return response()->json(new UserResource($user), 201);
    }

    public function index(): JsonResponse
    {
        $users = $this->getAllUsersUseCase->execute();

        return response()->json(UserResource::collection($users), 200);
    }
}
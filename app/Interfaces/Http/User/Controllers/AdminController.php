<?php

namespace App\Interfaces\Http\User\Controllers;

use App\Application\Admin\DTOs\CreateAdminDTO;
use App\Application\Admin\UseCases\CreateAdminUseCase;
use App\Interfaces\Http\Controller;
use App\Interfaces\Http\User\Requests\CreateAdminRequest;
use App\Interfaces\Http\User\Resources\AdminResource;
use Illuminate\Http\JsonResponse;

class AdminController extends Controller
{
    public function __construct(
        private readonly CreateAdminUseCase  $createAdminUseCase,
    ) {}

    public function store(CreateAdminRequest $request): JsonResponse
    {
        $dto  = CreateAdminDTO::fromArray($request->validated());
        $user = $this->createAdminUseCase->execute($dto);

        return response()->json(new AdminResource($user), 201);
    }
}
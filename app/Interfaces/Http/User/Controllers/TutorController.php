<?php

namespace App\Interfaces\Http\User\Controllers;

use App\Application\Tutor\UseCases\GetAllTutoresUseCase;
use App\Application\Tutor\DTOs\RegisterTutorDTO;
use App\Application\Tutor\UseCases\RegisterTutorUseCase;
use App\Interfaces\Http\Controller;
use App\Interfaces\Http\User\Requests\CreateTutorRequest;
use App\Interfaces\Http\User\Resources\TutorResource;
use Illuminate\Http\JsonResponse;

class TutorController extends Controller
{
    public function __construct(
        private readonly RegisterTutorUseCase  $registerTutorUseCase,
        private readonly GetAllTutoresUseCase $getAllTutoresUseCase,
    ) {}

    public function register(CreateTutorRequest $request): JsonResponse
    {
        $dto  = RegisterTutorDTO::fromArray($request->validated());
        $user = $this->registerTutorUseCase->execute($dto);

        return response()->json(new TutorResource($user), 201);
    }

    public function index(): JsonResponse
    {
        $users = $this->getAllTutoresUseCase->execute();

        return response()->json(TutorResource::collection($users), 200);
    }
}
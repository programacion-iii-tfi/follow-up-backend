<?php

namespace App\Interfaces\Http\User\Controllers;

use App\Application\Tutor\UseCases\GetAllTutoresUseCase;
use App\Application\Tutor\DTOs\RegisterTutorDTO;
use App\Application\Tutor\UseCases\RegisterTutorUseCase;
use App\Domain\User\Repositories\TutorRepositoryInterface;
use App\Domain\User\ValueObjects\UserId;
use App\Interfaces\Http\Controller;
use App\Interfaces\Http\User\Requests\CreateTutorRequest;
use App\Interfaces\Http\User\Resources\TutorResource;
use Illuminate\Http\JsonResponse;

class TutorController extends Controller
{
    public function __construct(
        private readonly RegisterTutorUseCase  $registerTutorUseCase,
        private readonly GetAllTutoresUseCase $getAllTutoresUseCase,
        private readonly TutorRepositoryInterface $tutorRepository
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

    public function show(string $id): JsonResponse
    {
        $tutor = $this->tutorRepository->findById(new UserId($id));

        if (!$tutor) {
            return response()->json(['message' => 'Tutor no encontrado'], 404);
        }

        return response()->json(new TutorResource($tutor));
    }

    public function destroy(string $id): JsonResponse
    {
        $this->tutorRepository->delete(new UserId($id));

        return response()->json('Tutor eliminado', 204);
    }

    public function findByDni(string $dni): JsonResponse
    {
        $tutor = $this->tutorRepository->findByDni(intval($dni));

        if (!$tutor) {
            return response()->json(['message' => 'Tutor no encontrado'], 404);
        }

        return response()->json(new TutorResource($tutor));
    }
}
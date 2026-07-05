<?php

namespace App\Interfaces\Http\User\Controllers;

use App\Interfaces\Http\Controller;
use App\Application\Alumno\UseCases\CreateAlumnoUseCase;
use App\Application\Alumno\UseCases\GetAllAlumnosUseCase;
use App\Application\Alumno\DTOs\CreateAlumnoDTO;
use App\Domain\User\Repositories\AlumnoRepositoryInterface;
use App\Domain\User\ValueObjects\UserId;
use Illuminate\Http\JsonResponse;
use App\Interfaces\Http\User\Requests\CreateAlumnoRequest;
use App\Interfaces\Http\User\Resources\AlumnoResource;

class AlumnoController extends Controller
{
    public function __construct(
        private readonly CreateAlumnoUseCase  $createAlumnoUseCase,
        private readonly GetAllAlumnosUseCase $getAllAlumnosUseCase,
        private readonly AlumnoRepositoryInterface $alumnoRepository
    ) {}

    public function store(CreateAlumnoRequest $request): JsonResponse
    {
        $dto  = CreateAlumnoDTO::fromArray($request->validated());
        $user = $this->createAlumnoUseCase->execute($dto);

        return response()->json(new AlumnoResource($user), 201);
    }

    public function index(): JsonResponse
    {
        $users = $this->getAllAlumnosUseCase->execute();

        return response()->json(AlumnoResource::collection($users), 200);
    }

    public function show(string $id): JsonResponse
    {
        $alumno = $this->alumnoRepository->findById(new UserId($id));

        if (!$alumno) {
            return response()->json(['message' => 'Alumno no encontrado'], 404);
        }

        return response()->json(new AlumnoResource($alumno));
    }

    public function destroy(string $id): JsonResponse
    {
        $this->alumnoRepository->destroy(new UserId($id));

        return response()->json('Alumno eliminado', 204);
    }
}
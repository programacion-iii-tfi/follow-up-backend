<?php

namespace App\Interfaces\Http\User\Controllers;

use App\Interfaces\Http\Controller;
use App\Application\Alumno\UseCases\CreateAlumnoUseCase;
use App\Application\Alumno\UseCases\GetAllAlumnosUseCase;
use App\Application\User\DTOs\CreateAlumnoDTO;
use Illuminate\Http\JsonResponse;
use App\Interfaces\Http\User\Requests\CreateAlumnoRequest;
use App\Interfaces\Http\User\Resources\AlumnoResource;

class AlumnoController extends Controller
{
    public function __construct(
        private readonly CreateAlumnoUseCase  $createAlumnoUseCase,
        private readonly GetAllAlumnosUseCase $getAllAlumnosUseCase,
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
}
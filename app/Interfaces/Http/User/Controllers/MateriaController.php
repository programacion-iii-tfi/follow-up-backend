<?php

namespace App\Interfaces\Http\User\Controllers;

use App\Application\Materia\UseCases\GetAllMateriasUseCase;
use App\Application\Materia\DTOs\CreateMateriaDTO;
use App\Application\Materia\UseCases\CreateMateriaUseCase;
use App\Domain\User\Repositories\MateriaRepositoryInterface;
use App\Interfaces\Http\Controller;
use App\Interfaces\Http\User\Requests\CreateMateriaRequest;
use App\Interfaces\Http\User\Resources\MateriaResource;
use Illuminate\Http\JsonResponse;

class MateriaController extends Controller
{
    public function __construct(
        private readonly CreateMateriaUseCase  $createMateriaUseCase,
        private readonly GetAllMateriasUseCase $getAllMateriasUseCase,
        private readonly MateriaRepositoryInterface $materiaRepository
    ) {}

    public function store(CreateMateriaRequest $request): JsonResponse
    {
        $dto  = CreateMateriaDTO::fromArray($request->validated());
        $materia = $this->createMateriaUseCase->execute($dto);

        return response()->json(new MateriaResource($materia), 201);
    }

    public function index(): JsonResponse
    {
        $materias = $this->getAllMateriasUseCase->execute();

        return response()->json(MateriaResource::collection($materias), 200);
    }

    public function show(string $id): JsonResponse
    {
        $docente = $this->materiaRepository->findById(intval($id));

        if (!$docente) {
            return response()->json(['message' => 'Materia no encontrada'], 404);
        }

        return response()->json(new MateriaResource($docente));
    }

    public function destroy(string $id): JsonResponse
    {
        $this->materiaRepository->destroy(intval($id));

        return response()->json('Materia eliminada', 204);
    }
}
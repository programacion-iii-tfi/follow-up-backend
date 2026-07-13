<?php

namespace App\Application\Materia\UseCases;

use App\Domain\User\Entities\Materia;
use App\Domain\User\Repositories\MateriaRepositoryInterface;

class GetAllMateriasUseCase
{
    public function __construct(
        private readonly MateriaRepositoryInterface $materiaRepository
    ) {}

    /**
     * @return Materia[]
     */
    public function execute(): array
    {
        return $this->materiaRepository->all();
    }
}
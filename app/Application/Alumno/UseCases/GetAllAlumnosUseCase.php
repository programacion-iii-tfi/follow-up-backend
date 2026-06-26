<?php

namespace App\Application\Alumno\UseCases;

use App\Domain\User\Entities\Alumno;
use App\Domain\User\Repositories\AlumnoRepositoryInterface;

class GetAllAlumnosUseCase
{
    public function __construct(
        private readonly AlumnoRepositoryInterface $alumnoRepository
    ) {}

    /**
     * @return Alumno[]
     */
    public function execute(): array
    {
        return $this->alumnoRepository->all();
    }
}
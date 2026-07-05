<?php

namespace App\Application\Docente\UseCases;

use App\Domain\User\Entities\Docente;
use App\Domain\User\Repositories\DocenteRepositoryInterface;

class GetAllDocentesUseCase
{
    public function __construct(
        private readonly DocenteRepositoryInterface $docenteRepository
    ) {}

    /**
     * @return Docente[]
     */
    public function execute(): array
    {
        return $this->docenteRepository->all();
    }
}
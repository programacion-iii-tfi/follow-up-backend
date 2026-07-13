<?php

namespace App\Application\Tutor\UseCases;

use App\Domain\User\Entities\Docente;
use App\Domain\User\Repositories\TutorRepositoryInterface;

class GetAllTutoresUseCase
{
    public function __construct(
        private readonly TutorRepositoryInterface $tutorRepository
    ) {}

    /**
     * @return Docente[]
     */
    public function execute(): array
    {
        return $this->tutorRepository->all();
    }
}
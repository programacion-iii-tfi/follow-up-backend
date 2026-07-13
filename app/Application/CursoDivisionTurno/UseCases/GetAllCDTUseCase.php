<?php

namespace App\Application\CursoDivisionTurno\UseCases;

use App\Domain\User\Entities\CursoDivisionTurno;
use App\Domain\User\Repositories\CursoDivisionTurnoRepositoryInterface;

class GetAllCDTUseCase
{
    public function __construct(
        private readonly CursoDivisionTurnoRepositoryInterface $cursoDivisionTurnoRepository
    ) {}

    /**
     * @return CursoDivisionTurno[]
     */
    public function execute(): array
    {
        return $this->cursoDivisionTurnoRepository->all();
    }
}
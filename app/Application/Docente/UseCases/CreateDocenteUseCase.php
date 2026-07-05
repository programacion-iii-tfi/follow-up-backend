<?php

namespace App\Application\Docente\UseCases;

use App\Application\Docente\DTOs\CreateDocenteDTO;
use App\Domain\Shared\ValueObjects\FechaFormateada;
use App\Domain\User\Entities\Docente;
use App\Domain\User\Repositories\DocenteRepositoryInterface;
use App\Domain\User\ValueObjects\UserId;
use App\Domain\User\ValueObjects\UserName;

class CreateDocenteUseCase
{
    public function __construct(
        private readonly DocenteRepositoryInterface $docente_repository
    ) {}

    public function execute(CreateDocenteDTO $dto): Docente
    {
        $user = new Docente(
        id:       UserId::generate(),
        first_name:     $dto->first_name,
        last_name:      $dto->last_name,
        password:       bcrypt($dto->dni),
        dni:            $dto->dni,
        telephone:      $dto->telephone,
        address:        $dto->address,
        username:       new UserName('DOC',$dto->dni,new FechaFormateada($dto->fecha_ingreso)->toYears()),
        fecha_ingreso:  new FechaFormateada($dto->fecha_ingreso),
        );

        return $this->docente_repository->save($user);
    }
}
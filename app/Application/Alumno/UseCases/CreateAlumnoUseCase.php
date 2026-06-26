<?php

namespace App\Application\Alumno\UseCases;

use App\Application\User\DTOs\CreateAlumnoDTO;
use App\Domain\User\Entities\Alumno;
use App\Domain\User\ValueObjects\UserId;
use App\Domain\User\ValueObjects\UserName;
use App\Domain\User\Repositories\AlumnoRepositoryInterface;
use App\Domain\User\ValueObjects\CodigoInstitucional;

class CreateAlumnoUseCase
{
    public function __construct(
        private readonly AlumnoRepositoryInterface $userRepository
    ) {}

    public function execute(CreateAlumnoDTO $dto): Alumno
    {
        $user = new Alumno(
        id:       UserId::generate(),
        first_name:     $dto->first_name,
        last_name:      $dto->last_name,
        password: bcrypt($dto->password),
        dni:            $dto->dni,
        telephone:      $dto->telephone,
        address:        $dto->address,
        username: new UserName($dto->username),
        anio_ingreso: $dto->anio_ingreso,
        codigo_institucional: new CodigoInstitucional($dto->codigo_institucional),
        education_level: $dto->education_level,
        );

        return $this->userRepository->save($user);
    }
}
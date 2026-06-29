<?php

namespace App\Application\Alumno\UseCases;

use App\Application\Alumno\DTOs\CreateAlumnoDTO as DTOsCreateAlumnoDTO;
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

    public function execute(DTOsCreateAlumnoDTO $dto): Alumno
    {
        $user = new Alumno(
        id:       UserId::generate(),
        first_name:     $dto->first_name,
        last_name:      $dto->last_name,
        password:       bcrypt($dto->dni),
        dni:            $dto->dni,
        telephone:      $dto->telephone,
        address:        $dto->address,
        username: new UserName('EST',$dto->dni,$dto->anio_ingreso),
        anio_ingreso: $dto->anio_ingreso,
        codigo_institucional: new CodigoInstitucional($dto->codigo_institucional),
        education_level: $dto->education_level,
        );

        return $this->userRepository->save($user);
    }
}
<?php

namespace App\Application\Tutor\UseCases;

use App\Application\Tutor\DTOs\RegisterTutorDTO;
use App\Domain\User\Entities\Tutor;
use App\Domain\User\Repositories\TutorRepositoryInterface;
use App\Domain\User\ValueObjects\TutorAlumnoRelation;
use App\Domain\User\ValueObjects\UserEmail;
use App\Domain\User\ValueObjects\UserId;

class RegisterTutorUseCase
{
    public function __construct(
        private readonly TutorRepositoryInterface $tutorRepository
    ) {}

    public function execute(RegisterTutorDTO $dto): Tutor
    {
        $user = new Tutor(
        id:       UserId::generate(),
        first_name:     $dto->first_name,
        last_name:      $dto->last_name,
        password:       bcrypt($dto->dni),
        dni:            $dto->dni,
        telephone:      $dto->telephone ?? '',
        address:        $dto->address ?? '',
        email:          new UserEmail($dto->user_email),
        relationship:   TutorAlumnoRelation::from($dto->relacion),
        otra_relacion:  $dto->otra_relacion ?? ''
        );

        return $this->tutorRepository->save($user);
    }
}
<?php

namespace App\Application\Tutor\UseCases;

use App\Application\Tutor\DTOs\RegisterTutorDTO;
use App\Domain\User\Entities\Tutor;
use App\Domain\User\Exceptions\PreRegistroNoEncontradoException;
use App\Domain\User\Exceptions\TutorNoEncontradoException;
use App\Domain\User\Exceptions\TutorYaRegistradoException;
use App\Domain\User\Repositories\TutorAlumnoRepositoryInterface;
use App\Domain\User\Repositories\TutorRepositoryInterface;
use App\Domain\User\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterTutorUseCase
{
    public function __construct(
        private readonly TutorRepositoryInterface $tutorRepository,
        private readonly TutorAlumnoRepositoryInterface $tutorAlumnoRepository,
        private readonly UserRepositoryInterface $userRepository,
    ) {}

    public function execute(RegisterTutorDTO $dto): Tutor
    {
        return DB::transaction(function () use ($dto) {

            $tutorAlumno = $this->tutorAlumnoRepository->findPreRegistroPendiente(
                $dto->codigoInstitucional);
            if ($tutorAlumno === null) {
                throw new PreRegistroNoEncontradoException(
                    "No hay un vínculo pre-cargado con ese código institucional"
                );
            }

            
            $tutor = $this->tutorRepository->findById($tutorAlumno->tutorId());
            if ($tutor === null) {
                throw new TutorNoEncontradoException($tutorAlumno->tutorId());
            }

            if ($tutor->email() !== null) {
                throw new TutorYaRegistradoException($tutorAlumno->tutorId());
            }

            $user = $this->userRepository->findById($tutorAlumno->tutorId());

            if ($user === null) {
                throw new TutorNoEncontradoException($tutorAlumno->tutorId());
            }

            $user->updateUsername($dto->email);
            $user->updatePassword(Hash::make($dto->password), false);
            $tutor->setEmail($dto->email);
            $tutor->updatePassword(Hash::make($dto->password), false);

            $this->userRepository->save($user);
            $this->tutorRepository->save($tutor);

            return $tutor;
        });
    }
}
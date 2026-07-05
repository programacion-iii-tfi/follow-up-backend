<?php

namespace App\Application\User\UseCases;

use App\Application\User\DTOs\LoginUserDTO;
use App\Domain\User\Repositories\UserRepositoryInterface;
use App\Domain\User\ValueObjects\UserEmail;
use App\Domain\User\ValueObjects\UserRole;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use \App\Infrastructure\User\Persistence\UserModel;

class LoginUserUseCase
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function execute(LoginUserDTO $dto): array
    {
        $role = UserRole::from($dto->role); // lanza ValueError si el string no es un caso válido

        $user = $role === UserRole::TUTOR
            ? $this->userRepository->findByEmail(new UserEmail($dto->username))
            : $this->userRepository->findByUsername($dto->username, $role);

        if (!$user || !Hash::check($dto->password, $user->password())) {
            throw ValidationException::withMessages([
                'username' => ['Las credenciales son incorrectas.'],
            ]);
        }

        // Importante: evita que alguien loguee con role=ADMINISTRADOR
        // usando el username de un ALUMNO, si coincidiera por algún motivo.
        if ($user->role() !== $role) {
            throw ValidationException::withMessages([
                'role' => ['El rol indicado no corresponde al usuario.'],
            ]);
        }

        $model = UserModel::find($user->id()->value()); // ajustar accessor según tu UserId VO
        $model->tokens()->delete();
        $token = $model->createToken('api-token')->plainTextToken;

        return [
            'token' => $token,
            'rol'   => $user->role()->value,
        ];
    }
}
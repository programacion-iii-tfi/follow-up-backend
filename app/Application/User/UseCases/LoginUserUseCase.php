<?php

namespace App\Application\User\UseCases;

use App\Application\User\DTOs\LoginUserDTO;
use App\Domain\User\Repositories\UserRepositoryInterface;
use App\Domain\User\ValueObjects\UserEmail;
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
        $user = $this->userRepository->findByEmail(new UserEmail($dto->username));

        if (!$user || !Hash::check($dto->password, $user->password())) {
            throw ValidationException::withMessages([
                'email' => ['Las credenciales son incorrectas.'],
            ]);
        }

        $model = UserModel::where('email', $dto->username)->first();
        $model->tokens()->delete();
        $token = $model->createToken('api-token')->plainTextToken;

        return [
            'token' => $token,
            'rol'  => $user->role()->value,
        ];
    }
}
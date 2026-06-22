<?php
namespace App\Application\User\UseCases;

use App\Domain\User\Entities\User as UserEntity;
use App\Domain\User\ValueObjects\UserEmail;
use App\Domain\User\ValueObjects\UserId;
use App\Domain\User\ValueObjects\UserName;
use App\Domain\User\Repositories\UserRepositoryInterface;
use App\Application\User\DTOs\CreateUserDTO;
use App\Domain\User\ValueObjects\UserRole;


class CreateUserUseCase
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function execute(CreateUserDTO $dto): UserEntity
    {
        // Lógica de negocio acá (ej: verificar que no exista el email)
        $user = new UserEntity(
            id:       UserId::generate(),
            name:     new UserName($dto->name),
            email:    new UserEmail($dto->email),
            password: bcrypt($dto->password),
            role:     UserRole::from($data['role'] ?? UserRole::ALUMNO->value),
        );

        return $this->userRepository->save($user);
    }
}
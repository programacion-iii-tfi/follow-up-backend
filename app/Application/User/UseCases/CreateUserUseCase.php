<?php
namespace App\Application\User\UseCases;

use App\Domain\User\Entities\User as UserEntity;
use App\Domain\User\ValueObjects\UserId;
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
        $user = new UserEntity(
        id:       UserId::generate(),
        first_name:     $dto->first_name,
        last_name:      $dto->last_name,
        dni:            $dto->dni,
        telephone:      $dto->telephone,
        address:        $dto->address,
        password: bcrypt($dto->password),
        role: UserRole::from(strtolower($dto->role)),
        );

        return $this->userRepository->save($user);
    }
}
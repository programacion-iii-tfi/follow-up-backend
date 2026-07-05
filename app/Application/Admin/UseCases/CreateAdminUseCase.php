<?php

namespace App\Application\Admin\UseCases;

use App\Application\Admin\DTOs\CreateAdminDTO;
use App\Domain\User\Entities\Admin;
use App\Domain\User\Repositories\AdminRepositoryInterface;
use App\Domain\User\ValueObjects\UserId;

class CreateAdminUseCase
{
    public function __construct(
        private readonly AdminRepositoryInterface $adminRepository
    ) {}

    public function execute(CreateAdminDTO $dto): Admin
    {
        $user = new Admin(
        id:       UserId::generate(),
        first_name:     $dto->first_name,
        last_name:      $dto->last_name,
        password:       bcrypt($dto->password),
        username:       $dto->username,
        );

        return $this->adminRepository->save($user);
    }
}
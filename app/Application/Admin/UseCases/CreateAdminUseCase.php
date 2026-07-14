<?php

namespace App\Application\Admin\UseCases;

use App\Application\Admin\DTOs\CreateAdminDTO;
use App\Application\Admin\DTOs\RegisterAdminDTO;
use App\Domain\User\Entities\Admin;
use App\Domain\User\Repositories\AdminRepositoryInterface;
use App\Domain\User\ValueObjects\UserId;
use App\Domain\User\ValueObjects\UserName;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateAdminUseCase
{
    public function __construct(
        private readonly AdminRepositoryInterface $adminRepository,
    ) {}

    public function execute(CreateAdminDTO $dto): Admin
    {
        return DB::transaction(function () use ($dto) {
            $anio = (int) date('Y');

            $admin = new Admin(
                id: UserId::generate(),
                first_name: $dto->first_name,
                last_name: $dto->last_name,
                password: Hash::make($dto->password),
                username: $dto->username ?? new UserName('ADM', $dto->first_name, $anio),
            );

            $this->adminRepository->save($admin);

            return $admin;
        });
    }
}
<?php

namespace App\Application\Admin\UseCases;

use App\Domain\User\Entities\Admin;
use App\Domain\User\Repositories\AdminRepositoryInterface;

class GetAllAdminsUseCase
{
    public function __construct(
        private readonly AdminRepositoryInterface $adminRepository
    ) {}

    /**
     * @return Admin[]
     */
    public function execute(): array
    {
        return $this->adminRepository->all();
    }
}
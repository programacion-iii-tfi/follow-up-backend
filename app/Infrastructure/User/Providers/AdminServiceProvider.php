<?php

namespace App\Infrastructure\User\Providers;

use App\Domain\User\Repositories\AdminRepositoryInterface;
use App\Infrastructure\User\Persistence\Eloquent\EloquentAdminRepository as EloquentEloquentAdminRepository;
use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            AdminRepositoryInterface::class,
            EloquentEloquentAdminRepository::class
        );
    }
}
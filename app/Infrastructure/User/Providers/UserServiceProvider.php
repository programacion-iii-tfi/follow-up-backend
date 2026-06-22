<?php

namespace App\Infrastructure\User\Providers;

use App\Domain\User\Repositories\UserRepositoryInterface;
use App\Infrastructure\User\Persistence\EloquentUserRepository;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            EloquentUserRepository::class
        );
    }
}
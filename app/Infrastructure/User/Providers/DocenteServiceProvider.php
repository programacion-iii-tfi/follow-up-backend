<?php

namespace App\Infrastructure\User\Providers;

use App\Domain\User\Repositories\DocenteRepositoryInterface;
use App\Infrastructure\User\Persistence\Eloquent\EloquentDocenteRepository;
use Illuminate\Support\ServiceProvider;

class DocenteServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            DocenteRepositoryInterface::class,
            EloquentDocenteRepository::class
        );
    }
}
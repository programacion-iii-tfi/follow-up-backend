<?php

namespace App\Infrastructure\User\Providers;

use App\Domain\User\Repositories\AlumnoRepositoryInterface;
use App\Infrastructure\User\Persistence\EloquentAlumnoRepository;
use Illuminate\Support\ServiceProvider;

class AlumnoServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            AlumnoRepositoryInterface::class,
            EloquentAlumnoRepository::class
        );
    }
}
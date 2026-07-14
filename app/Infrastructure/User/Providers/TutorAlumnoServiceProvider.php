<?php

namespace App\Infrastructure\User\Providers;

use App\Domain\User\Repositories\TutorAlumnoRepositoryInterface;
use App\Infrastructure\User\Persistence\Eloquent\EloquentTutorAlumnoRepository;
use Illuminate\Support\ServiceProvider;

class TutorAlumnoServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            TutorAlumnoRepositoryInterface::class,
            EloquentTutorAlumnoRepository::class
        );
    }
}
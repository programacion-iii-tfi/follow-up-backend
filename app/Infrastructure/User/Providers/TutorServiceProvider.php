<?php

namespace App\Infrastructure\User\Providers;

use App\Domain\User\Repositories\TutorRepositoryInterface;
use App\Infrastructure\User\Persistence\Eloquent\EloquentTutorRepository as EloquentEloquentTutorRepository;
use Illuminate\Support\ServiceProvider;

class TutorServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            TutorRepositoryInterface::class,
            EloquentEloquentTutorRepository::class
        );
    }
}
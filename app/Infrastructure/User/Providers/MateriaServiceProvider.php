<?php

namespace App\Infrastructure\User\Providers;

use App\Domain\User\Repositories\MateriaRepositoryInterface;
use App\Infrastructure\User\Persistence\Eloquent\EloquentMateriaRepository;
use Illuminate\Support\ServiceProvider;

class MateriaServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            MateriaRepositoryInterface::class,
            EloquentMateriaRepository::class
        );
    }
}
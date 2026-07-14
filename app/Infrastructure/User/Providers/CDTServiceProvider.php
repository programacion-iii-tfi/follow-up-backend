<?php

namespace App\Infrastructure\User\Providers;

use App\Domain\User\Repositories\CursoDivisionTurnoRepositoryInterface;
use App\Infrastructure\User\Persistence\Eloquent\EloquentCDTRepository;
use Illuminate\Support\ServiceProvider;

class CDTServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            CursoDivisionTurnoRepositoryInterface::class,
            EloquentCDTRepository::class
        );
    }
}
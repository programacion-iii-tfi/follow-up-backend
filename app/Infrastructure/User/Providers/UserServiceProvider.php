<?php

namespace App\Infrastructure\User\Providers;

use App\Domain\User\Repositories\AdminRepositoryInterface;
use App\Domain\User\Repositories\AlumnoRepositoryInterface;
use App\Domain\User\Repositories\DocenteRepositoryInterface;
use App\Domain\User\Repositories\TutorRepositoryInterface;
use App\Domain\User\Repositories\UserRepositoryInterface;
use App\Infrastructure\User\Persistence\Eloquent\EloquentAdminRepository;
use App\Infrastructure\User\Persistence\Eloquent\EloquentAlumnoRepository;
use App\Infrastructure\User\Persistence\Eloquent\EloquentDocenteRepository;
use App\Infrastructure\User\Persistence\Eloquent\EloquentTutorRepository;
use App\Infrastructure\User\Persistence\Eloquent\EloquentUserRepository;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AlumnoRepositoryInterface::class, EloquentAlumnoRepository::class);
        $this->app->bind(DocenteRepositoryInterface::class, EloquentDocenteRepository::class);
        $this->app->bind(TutorRepositoryInterface::class, EloquentTutorRepository::class);
        $this->app->bind(AdminRepositoryInterface::class, EloquentAdminRepository::class);
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class); // ← esta línea
    }
}
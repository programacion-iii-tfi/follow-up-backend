<?php

use App\Infrastructure\User\Providers\AlumnoServiceProvider;
use App\Infrastructure\User\Providers\DocenteServiceProvider;
use App\Infrastructure\User\Providers\TutorServiceProvider;
use App\Providers\AppServiceProvider;
use App\Infrastructure\User\Providers\UserServiceProvider;

return [
    AppServiceProvider::class,
    UserServiceProvider::class,
    AlumnoServiceProvider::class,
    DocenteServiceProvider::class,
    TutorServiceProvider::class,
];

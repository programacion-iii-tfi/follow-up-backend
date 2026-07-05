<?php

use App\Interfaces\Http\User\Controllers\AdminController;
use App\Interfaces\Http\User\Controllers\AuthController;
use App\Interfaces\Http\User\Controllers\AlumnoController;
use App\Interfaces\Http\User\Controllers\DocenteController;
use App\Interfaces\Http\User\Controllers\TutorController;
use App\Interfaces\Http\User\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    // Públicas
    Route::post('login', [AuthController::class, 'login']);
    Route::post('users', [UserController::class, 'store']);
    Route::post('tutores/register', [TutorController::class, 'register']);
    Route::post('admins/register', [AdminController::class, 'store']);

    // Protegidas — requieren estar autenticado
    Route::middleware('auth:sanctum')->group(function () {

        Route::post('logout', [AuthController::class, 'logout']);
        Route::put('password', [AuthController::class, 'changePassword']); // cualquier rol autenticado

        // ── Alumnos ──
        // Admin y Docente gestionan el CRUD completo de alumnos
        Route::middleware('role:administrador,docente')->group(function () {
            Route::apiResource('alumnos', AlumnoController::class)->except(['show']);
        });
        // El propio alumno, su tutor, docente o admin pueden ver el detalle
        Route::middleware('role:administrador,docente,tutor,alumno')->group(function () {
            Route::get('alumnos/{id}', [AlumnoController::class, 'show']);
        });

        // ── Docentes ──
        // Solo Admin gestiona altas/bajas/modificaciones de docentes
        Route::middleware('role:administrador')->group(function () {
            Route::apiResource('docentes', DocenteController::class);
        });

        // ── Tutores ──
        // Solo Admin gestiona tutores (salvo el registro público ya definido arriba)
        Route::middleware('role:administrador')->group(function () {
            Route::apiResource('tutores', TutorController::class)->except(['store', 'show']);
        });
        // El propio tutor o un admin pueden ver el detalle y los alumnos asociados
        Route::middleware('role:administrador,tutor')->group(function () {
            Route::get('tutores/{id}', [TutorController::class, 'show']);
            Route::get('tutores/{id}/alumnos', [TutorController::class, 'alumnos']);
        });

        // ── Admins ──
        // Solo un Admin gestiona otros admins (salvo el registro público ya definido arriba)
        Route::middleware('role:administrador')->group(function () {
            Route::apiResource('admins', AdminController::class)->except(['store']);
        });
    });
});
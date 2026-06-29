<?php

namespace App\Domain\User\Entities;

use App\Domain\User\ValueObjects\UserId;
use App\Domain\User\ValueObjects\UserRole;

class User
{
    public function __construct(
        private readonly UserId    $id,
        private string  $first_name,
        private string  $last_name,
        private ?int $dni,
        private ?string $telephone,
        private ?string  $address,
        private string  $password,
        private readonly UserRole $role,
        private bool $must_change_password,
    ) {}

    public function id(): UserId
    {
        return $this->id;
    }

    public function firstName(): string
    {
        return $this->first_name;
    }

    public function lastName(): string
    {
        return $this->last_name;
    }

    public function dni(): int
    {
        return $this->dni;
    }

    public function telephone(): string
    {
        return $this->telephone;
    }

    public function address(): string
    {
        return $this->address;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function role(): UserRole 
    { 
        return $this->role; 
    }

    public function mustChangePassword(): bool
    {
        return $this->must_change_password;
    }

    public function isAdministrador(): bool
    {
        return $this->role === UserRole::ADMINISTRADOR;
    }

    public function isDocente(): bool
    {
        return $this->role === UserRole::DOCENTE;
    }

    public function isTutor(): bool
    {
        return $this->role === UserRole::TUTOR;
    }

    public function isAlumno(): bool
    {
        return $this->role === UserRole::ALUMNO;
    }

    public function updateUser(string $first_name, string $last_name, ?int $dni, ?string $telephone, ?string $address): void
    {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->dni = $dni;
        $this->telephone = $telephone;
        $this->address = $address;
    }
}
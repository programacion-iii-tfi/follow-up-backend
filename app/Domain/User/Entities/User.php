<?php

namespace App\Domain\User\Entities;

use App\Domain\User\ValueObjects\UserId;
use App\Domain\User\ValueObjects\UserEmail;
use App\Domain\User\ValueObjects\UserName;
use App\Domain\User\ValueObjects\UserRole;

class User
{
    public function __construct(
        private readonly UserId    $id,
        private readonly UserName  $name,
        private readonly UserEmail $email,
        private readonly string    $password,
         private readonly UserRole  $role,
    ) {}

    public function id(): UserId
    {
        return $this->id;
    }

    public function name(): UserName
    {
        return $this->name;
    }

    public function email(): UserEmail
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function role(): UserRole 
    { 
        return $this->role; 
    }

    public function isAdministrador(): bool
    {
        return $this->role === UserRole::ADMINISTRADOR;
    }
}
<?php

namespace App\Application\User\DTOs;
use App\Domain\User\ValueObjects\UserRole;

class CreateUserDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
        public readonly string $role,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name:  $data['name'],
            email: $data['email'],
            password: $data['password'],
            role:  $data['role'] ?? UserRole::ALUMNO->value,
        );
    }
}
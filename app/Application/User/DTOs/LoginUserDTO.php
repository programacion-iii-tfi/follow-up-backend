<?php

namespace App\Application\User\DTOs;
use App\Domain\User\ValueObjects\UserRole;

class LoginUserDTO
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            email:    $data['email'],
            password: $data['password'],
        );
    }
}
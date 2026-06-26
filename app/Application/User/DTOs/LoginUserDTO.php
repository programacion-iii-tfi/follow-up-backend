<?php

namespace App\Application\User\DTOs;
use App\Domain\User\ValueObjects\UserRole;

class LoginUserDTO
{
    public function __construct(
        public readonly string $username,
        public readonly string $password,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            username: $data['username'],
            password: $data['password'],
        );
    }
}
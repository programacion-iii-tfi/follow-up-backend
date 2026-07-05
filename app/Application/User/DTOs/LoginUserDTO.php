<?php

namespace App\Application\User\DTOs;

class LoginUserDTO
{
    public function __construct(
        public readonly string $username,
        public readonly string $password,
        public readonly string $role,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            username: $data['username'],
            password: $data['password'],
            role:     $data['role']
        );
    }
}
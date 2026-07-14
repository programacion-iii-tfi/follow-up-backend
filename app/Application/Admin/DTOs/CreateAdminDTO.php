<?php

namespace App\Application\Admin\DTOs;

class CreateAdminDTO
{
    public function __construct(
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly string $username,
        public readonly string $password,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
        first_name:     $data['first_name'],
        last_name:      $data['last_name'],
        username:       $data['username'],
        password:       $data['password'],
        );
    }
}
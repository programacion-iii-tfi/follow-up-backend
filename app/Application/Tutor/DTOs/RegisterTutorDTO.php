<?php

namespace App\Application\Tutor\DTOs;

class RegisterTutorDTO
{
    public function __construct(
        public readonly string $codigoInstitucional,
        public readonly string $email,
        public readonly string $password,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            codigoInstitucional: $data['codigo_institucional'],
            email: $data['email'],
            password: $data['password'],
        );
    }
}

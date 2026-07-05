<?php

namespace App\Application\Tutor\DTOs;

class RegisterTutorDTO
{
    public function __construct(
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly string $password,
        public readonly ?int $dni,
        public readonly ?string $telephone,
        public readonly ?string $address,
        public readonly string $user_email,
        public readonly string $relacion,
        public readonly ?string $otra_relacion,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            first_name:           $data['first_name'],
            last_name:            $data['last_name'],
            password:             $data['password'],
            dni:                  $data['dni'] ?? null,
            telephone:            $data['telephone'] ?? null,
            address:              $data['address'] ?? null,
            user_email:           $data['user_email'],
            relacion:             $data['relacion'],
            otra_relacion:        $data['otra_relacion'] ?? null,
        );
    }
}
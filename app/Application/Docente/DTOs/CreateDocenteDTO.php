<?php

namespace App\Application\Docente\DTOs;

class CreateDocenteDTO
{
    public function __construct(
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly string $password,
        public readonly ?int $dni,
        public readonly ?string $telephone,
        public readonly ?string $address,
        public readonly string $username,
        public readonly string $fecha_ingreso,
        public readonly string $codigo_institucional,
        public readonly string $education_level,
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
        username:             $data['username'],
        fecha_ingreso:        $data['fecha_ingreso'],
        codigo_institucional: $data['codigo_institucional'],
        education_level:      $data['education_level'],
        );
    }
}
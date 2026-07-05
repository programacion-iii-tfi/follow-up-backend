<?php

namespace App\Application\Docente\DTOs;

class CreateDocenteDTO
{
    public function __construct(
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly ?int $dni,
        public readonly ?string $telephone,
        public readonly ?string $address,
        public readonly string $fecha_ingreso,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
        first_name:           $data['first_name'],
        last_name:            $data['last_name'],
        dni:                  $data['dni'] ?? null,
        telephone:            $data['telephone'] ?? null,
        address:              $data['address'] ?? null,
        fecha_ingreso:        $data['fecha_ingreso'],
        );
    }
}
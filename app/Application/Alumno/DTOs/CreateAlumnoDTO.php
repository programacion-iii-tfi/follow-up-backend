<?php

namespace App\Application\Alumno\DTOs;

class CreateAlumnoDTO
{
    public function __construct(
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly ?string $dni,
        public readonly ?string $telephone,
        public readonly ?string $address,
        public readonly string $anio_ingreso,
        public readonly string $education_level,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
        first_name:     $data['first_name'],
        last_name:      $data['last_name'],
        dni:            $data['dni'] ?? null,
        telephone:      $data['telephone'] ?? null,
        address:        $data['address'] ?? null,
        anio_ingreso:   $data['anio_ingreso'],
        education_level: $data['education_level'],
        );
    }
}
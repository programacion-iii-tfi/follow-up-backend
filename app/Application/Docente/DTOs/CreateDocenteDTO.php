<?php

namespace App\Application\Docente\DTOs;

class CreateDocenteDTO
{
    public function __construct(
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly int $dni,
        public readonly string $telephone,
        public readonly string $fechaIngreso,
        public readonly int $cursoDivisionTurnoId,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            firstName: $data['first_name'],
            lastName: $data['last_name'],
            dni: (int) $data['dni'],
            telephone: $data['telephone'],
            fechaIngreso: $data['fecha_ingreso'],
            cursoDivisionTurnoId: (int) $data['curso_division_turno_id'],
        );
    }
}
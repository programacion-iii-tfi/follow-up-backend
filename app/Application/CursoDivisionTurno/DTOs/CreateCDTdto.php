<?php

namespace App\Application\CursoDivisionTurno\DTOs;

class CreateCDTdto
{
    public function __construct(
        public readonly int $curso,
        public readonly string $division,
        public readonly string $turno,
        public readonly int $capacidadMaxima,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            curso: (int) $data['curso'],
            division: strtoupper($data['division']),
            turno: $data['turno'],
            capacidadMaxima: isset($data['capacidad_maxima']) ? (int) $data['capacidad_maxima'] : 30,
        );
    }
}
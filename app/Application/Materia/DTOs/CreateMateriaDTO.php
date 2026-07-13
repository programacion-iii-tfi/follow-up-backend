<?php

namespace App\Application\Materia\DTOs;

class CreateMateriaDTO
{
    public function __construct(
        public readonly string $nombre,
        public readonly string $descripcion,
        public readonly string $turno,
        public readonly string $docenteId,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            nombre: $data['nombre'],
            descripcion: $data['descripcion'],
            turno: $data['turno'],
            docenteId: $data['docente_id'],
        );
    }
}
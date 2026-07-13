<?php

namespace App\Application\TutorAlumno\DTOs;

class VincularTutorAlumnoDTO
{
    public function __construct(
        public readonly string $alumnoId,
        public readonly string $tutorId,
        public readonly string $relationship,
        public readonly ?string $otraRelacion,
        public readonly string $codigoInstitucional,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            alumnoId: $data['alumno_id'],
            tutorId: $data['tutor_id'],
            relationship: $data['relationship'],
            otraRelacion: $data['otra_relacion'] ?? null,
            codigoInstitucional: $data['codigo_institucional'],
        );
    }
}
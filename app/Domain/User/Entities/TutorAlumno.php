<?php

namespace App\Domain\User\Entities;

use App\Domain\User\ValueObjects\CodigoInstitucional;
use App\Domain\User\ValueObjects\TutorAlumnoRelation;
use App\Domain\User\ValueObjects\UserId;

class TutorAlumno
{
    public function __construct(
        private UserId $id,
        private UserId $alumno_id,
        private UserId $tutor_id,
        private TutorAlumnoRelation $relationship,
        private ?string $otra_relacion,
        private CodigoInstitucional $codigo_institucional
    ) {
        $this->validateRelationship($relationship, $otra_relacion);
    }

    public function id(): UserId { return $this->id; }

    public function alumnoId(): UserId { return $this->alumno_id; }

    public function tutorId(): UserId { return $this->tutor_id; }

    public function relationship(): TutorAlumnoRelation { return $this->relationship; }

    public function otraRelacion(): ?string { return $this->otra_relacion; }

    public function codigoInstitucional(): CodigoInstitucional { return $this->codigo_institucional;}


    private function validateRelationship(TutorAlumnoRelation $relationship, ?string $otraRelacion): void
    {
        if ($relationship === TutorAlumnoRelation::OTRA && empty($otraRelacion)) {
            throw new \InvalidArgumentException("Debe especificar la relación cuando selecciona 'Otra'.");
        }

        if ($relationship !== TutorAlumnoRelation::OTRA && $otraRelacion !== null) {
            throw new \InvalidArgumentException("El campo 'otra relación' solo aplica cuando la relación es 'Otra'.");
        }
    }
}
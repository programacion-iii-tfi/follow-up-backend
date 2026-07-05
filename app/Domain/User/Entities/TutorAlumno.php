<?php

namespace App\Domain\User\Entities;

use App\Domain\User\ValueObjects\UserId;

class TutorAlumno
{
    public function __construct(
        private UserId  $tutor_id,
        private UserId  $alumno_id,
    ) {}

    public function tutorId(): UserId
    {
        return $this->tutor_id;
    }

    public function alumnoId(): UserId
    {
        return $this->alumno_id;
    }
}
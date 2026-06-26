<?php 

namespace App\Domain\User\ValueObjects;

enum TutorAlumnoRelation: string
{
    case PADRE        = 'padre';
    case MADRE        = 'madre';
    case OTRO         = 'otro';

    public function label(): string
    {
        return match($this) {
            TutorAlumnoRelation::PADRE => 'Padre',
            TutorAlumnoRelation::MADRE => 'Madre',
            TutorAlumnoRelation::OTRO  => 'Otro',
        };
    }
}
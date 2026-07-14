<?php 

namespace App\Domain\User\ValueObjects;

enum TutorAlumnoRelation: string
{
    case PADRE        = 'padre';
    case MADRE        = 'madre';
    case OTRA         = 'otra';

    public function label(): string
    {
        return match($this) {
            TutorAlumnoRelation::PADRE => 'Padre',
            TutorAlumnoRelation::MADRE => 'Madre',
            TutorAlumnoRelation::OTRA  => 'Otra',
        };
    }
}
<?php 

namespace App\Domain\User\ValueObjects;

enum UserRole: string
{
    case DOCENTE       = 'docente';
    case ALUMNO        = 'alumno';
    case TUTOR         = 'tutor';
    case ADMINISTRADOR = 'administrador';

    public function label(): string
    {
        return match($this) {
            UserRole::DOCENTE       => 'Docente',
            UserRole::ALUMNO        => 'Alumno',
            UserRole::TUTOR         => 'Tutor',
            UserRole::ADMINISTRADOR => 'Administrador',
        };
    }

    public function canManageUsers(): bool
    {
        return $this === UserRole::ADMINISTRADOR;
    }
}
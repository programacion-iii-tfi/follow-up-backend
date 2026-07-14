<?php

namespace App\Domain\User\Entities;

use App\Domain\Shared\ValueObjects\FechaFormateada;
use App\Domain\User\ValueObjects\UserId;
use App\Domain\User\ValueObjects\UserName;
use App\Domain\User\ValueObjects\UserRole;

class Docente extends User
{
    public function __construct(
        UserId   $id,
        string $first_name,
        string $last_name,
        int $dni,
        string $username,
        string $password,
        private string $telephone,
        private FechaFormateada $fecha_ingreso,
        private int $curso_division_turno_id,
    ) {
        parent::__construct($id, $first_name, $last_name, $dni, $username, $password, UserRole::DOCENTE, true);
    }

    public function fechaIngreso(): FechaFormateada { return $this->fecha_ingreso; }

    public function setFechaIngreso(string $fecha): void
    {
        $this->fecha_ingreso = new FechaFormateada($fecha);
    }

    public function telephone(): string { return $this->telephone;}

    public function setTelephone(string $telephone): void { 
        $this->telephone =  $telephone;
    }

    public function cursoDivisionTurno(): int { return $this->curso_division_turno_id; }

    public function setCursoDivisionTurno(int $curso_division_turno_id): void
    {
        $this->curso_division_turno_id = $curso_division_turno_id;
    }

}
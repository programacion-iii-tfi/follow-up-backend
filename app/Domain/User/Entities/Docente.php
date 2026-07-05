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
        string $telephone,
        string $address,
        string $password,
        private UserName $username,
        private FechaFormateada $fecha_ingreso,
    ) {
        parent::__construct($id, $first_name, $last_name, $dni, $telephone, $address, $password, UserRole::DOCENTE, true);
    }

    public function fechaIngreso(): FechaFormateada { return $this->fecha_ingreso; }

    public function setFechaIngreso(string $fecha): void
    {
        $this->fecha_ingreso = new FechaFormateada($fecha);
    }

    public function username(): string { return $this->username->value(); }

    public function setUsername(string $dni, string $fecha_ingreso): void
    {
        $anio = date("Y", strtotime($fecha_ingreso));
        $this->username = new UserName('DOC', $dni, strval($anio));
    }

}
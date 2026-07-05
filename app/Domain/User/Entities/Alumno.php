<?php

namespace App\Domain\User\Entities;

use App\Domain\User\ValueObjects\UserId;
use App\Domain\User\ValueObjects\UserName;
use App\Domain\User\ValueObjects\UserRole;
use App\Domain\User\ValueObjects\CodigoInstitucional;

class Alumno extends User
{
    public function __construct(
        UserId $id,
        string $first_name,
        string $last_name,
        int $dni,
        string $telephone,
        string $address,
        string $password,
        private UserName $username,
        private int $anio_ingreso,
        private CodigoInstitucional $codigo_institucional,
        private string $education_level,
    ) {
        parent::__construct($id, $first_name, $last_name, $dni, $telephone, $address, $password, UserRole::ALUMNO,true);
    }

    public function username(): string { return $this->username->value(); }

    public function anioIngreso(): int { return $this->anio_ingreso; }

    public function codigoInstitucional(): string { return $this->codigo_institucional->value(); }

    public function educationLevel(): string { return $this->education_level; }

    public function setUsername(int $dni, int $anio_ingreso): void
    {
        $this->username = new UserName('EST',$dni,$anio_ingreso);
    }

    public function setAnioIngreso(int $anio_ingreso): void
    {
        $this->anio_ingreso = $anio_ingreso;
    }

    public function setCodigoInstitucional(CodigoInstitucional $codigo_institucional): void
    {
        $this->codigo_institucional = $codigo_institucional;
    }

    public function setEducationLevel(string $education_level): void
    {
        $this->education_level = $education_level;
    }
}
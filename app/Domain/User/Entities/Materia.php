<?php

namespace App\Domain\User\Entities;

use App\Domain\User\ValueObjects\TurnoEscolar;
use App\Domain\User\ValueObjects\UserId;

class Materia
{
    public function __construct(
        private readonly int $id,
        private string $nombre,
        private string $descripcion,
        private TurnoEscolar $turno,
        private UserId $docente,
    ) {}

    public function id(): int { return $this->id; }
    public function nombre(): string { return $this->nombre; }
    public function descripcion(): string { return $this->descripcion; }
    public function turno(): TurnoEscolar { return $this->turno; }
    public function docente(): UserId { return $this->docente; }

    public function setNombre(string $nombre): void { $this->nombre = $nombre; }
    public function setDescripcion(string $descripcion): void { $this->descripcion = $descripcion;}
    public function setTurno(TurnoEscolar $turno): void { $this->turno = $turno; }
    public function setDocente(UserId $docente): void { $this->docente = $docente; }

}
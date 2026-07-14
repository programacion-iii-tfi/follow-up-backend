<?php

namespace App\Domain\User\Exceptions;


class CDTNoEncontradoException extends DomainNotFoundException
{
    public function __construct(string $message = "No se encontró el Curso División Turno especificado.")
    {
        parent::__construct($message);
    }
}
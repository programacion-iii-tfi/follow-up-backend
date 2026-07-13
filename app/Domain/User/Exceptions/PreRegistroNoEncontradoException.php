<?php

namespace App\Domain\User\Exceptions;


class PreRegistroNoEncontradoException extends DomainNotFoundException
{
    public function __construct(string $message = "No se encontró el alumno especificado.")
    {
        parent::__construct($message);
    }
}
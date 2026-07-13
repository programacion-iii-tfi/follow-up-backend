<?php

namespace App\Domain\User\Exceptions;


class DocenteNoEncontradoException extends DomainNotFoundException
{
    public function __construct(string $message = "No se encontró el docente especificado.")
    {
        parent::__construct($message);
    }
}
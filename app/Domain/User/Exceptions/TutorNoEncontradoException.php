<?php

namespace App\Domain\User\Exceptions;


class TutorNoEncontradoException extends DomainNotFoundException
{
    public function __construct(string $message = "No se encontró el tutor especificado.")
    {
        parent::__construct($message);
    }
}
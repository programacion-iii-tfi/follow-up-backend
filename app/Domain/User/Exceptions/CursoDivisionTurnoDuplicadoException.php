<?php

namespace App\Domain\User\Exceptions;


class CursoDivisionTurnoDuplicadoException extends DomainNotFoundException
{
    public function __construct(string $message = "El curso, división y turno ya se encuentra registrado.")
    {
        parent::__construct($message);
    }
}
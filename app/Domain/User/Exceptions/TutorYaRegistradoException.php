<?php

namespace App\Domain\User\Exceptions;


class TutorYaRegistradoException extends DomainNotFoundException
{
    public function __construct(string $message = "El tutor ya se encuentra registrado.")
    {
        parent::__construct($message);
    }
}
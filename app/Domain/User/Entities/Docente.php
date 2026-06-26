<?php

namespace App\Domain\User\Entities;

use App\Domain\User\ValueObjects\UserId;
use App\Domain\User\ValueObjects\UserName;
use App\Domain\User\ValueObjects\UserRole;

class Docente extends User
{
    public function __construct(
        UserId   $id,
        string $first_name,
        string $last_name,
        string   $password,
        int $dni,
        string $telephone,
        string $address,
        private UserName $username, // DOC-DNI-AÑO
        private string $legajo, 
    ) {
        parent::__construct($id, $first_name, $last_name, $dni, $telephone, $address, $password, UserRole::DOCENTE);
    }

    public function username(): string { return $this->username; }

    public function legajo(): string { return $this->legajo; }

    public function setUsername(string $username): void
    {
        $this->username = new UserName($username);
    }

    public function setLegajo(string $legajo): void
    {
        $this->legajo = $legajo;
    }
}
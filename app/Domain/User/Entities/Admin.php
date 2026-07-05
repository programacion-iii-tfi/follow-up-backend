<?php

namespace App\Domain\User\Entities;

use App\Domain\User\ValueObjects\UserId;
use App\Domain\User\ValueObjects\UserRole;

class Admin extends User
{
    public function __construct(
        UserId $id,
        string $first_name,
        string $last_name,
        string $password,
        private string $username,
    ) {
        parent::__construct($id, $first_name, $last_name,null, null, null, $password, UserRole::ADMINISTRADOR,false);
    }

    public function username(): string { return $this->username; }

    public function setUsername(string $newUserName): void
    {
        $this->username = $newUserName;
    }
}
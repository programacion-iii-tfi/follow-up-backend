<?php

namespace App\Domain\User\Entities;

use App\Domain\User\ValueObjects\UserEmail;
use App\Domain\User\ValueObjects\UserId;
use App\Domain\User\ValueObjects\UserRole;

class Tutor extends User
{
    public function __construct(
        UserId              $id,
        string              $first_name,
        string              $last_name,
        int                 $dni,
        private string      $telephone,
        private ?UserEmail   $email,
    ) {
        parent::__construct($id, $first_name, $last_name, $dni, $email?->value(),null, UserRole::TUTOR, false);
    }

    public function telephone(): string { return $this->telephone;}

    public function setTelephone(string $telephone): void { 
        $this->telephone =  $telephone;
    }

    public function email(): ?UserEmail { return $this->email; }

    public function setEmail(string $email): void
    {
        $this->email = new UserEmail($email);
        $this->updateUsername($email);
    }
    
}
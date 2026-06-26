<?php

namespace App\Domain\User\Entities;

use App\Domain\User\ValueObjects\TutorAlumnoRelation;
use App\Domain\User\ValueObjects\UserEmail;
use App\Domain\User\ValueObjects\UserId;
use App\Domain\User\ValueObjects\UserRole;

class Tutor extends User
{
    public function __construct(
        UserId   $id,
        string $first_name,
        string $last_name,
        string $password,
        int $dni,
        string $telephone,
        string $address,
        private UserEmail $email,
        private TutorAlumnoRelation $relationship,
        private ?string $otra_relacion,
    ) {
        parent::__construct($id, $first_name, $last_name, $dni, $telephone, $address, $password, UserRole::TUTOR);
    }

    public function email(): UserEmail { return $this->email; }

    public function relationship(): TutorAlumnoRelation { return $this->relationship; }

    public function otraRelacion(): ?string { return $this->otra_relacion; }

    public function setEmail(string $email): void
    {
        $this->email = new UserEmail($email);
    }

    public function setRelationship(TutorAlumnoRelation $relationship): void
    {
        $this->relationship = $relationship;
    }

    public function setOtraRelacion(?string $otra_relacion): void
    {
        $this->otra_relacion = $otra_relacion;
    }
}
<?php

namespace App\Domain\User\Entities;

use App\Domain\User\ValueObjects\TutorAlumnoRelation;
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
        string              $telephone,
        string              $address,
        string              $password,
        private UserEmail           $email,
        private TutorAlumnoRelation $relationship,
        private ?string             $otra_relacion,
    ) {
        $this->validateRelationship($relationship, $otra_relacion);
        parent::__construct($id, $first_name, $last_name, $dni, $telephone, $address, $password, UserRole::TUTOR, false);
    }

    public function email(): UserEmail { return $this->email; }

    public function relationship(): TutorAlumnoRelation { return $this->relationship; }

    public function otraRelacion(): ?string { return $this->otra_relacion; }

    public function setEmail(string $email): void
    {
        $this->email = new UserEmail($email);
    }

    public function setRelationship(TutorAlumnoRelation $relationship, ?string $otraRelacion = null): void
    {
        $this->validateRelationship($relationship,$otraRelacion);
        $this->relationship  = $relationship;
        $this->otra_relacion = $otraRelacion;
    }

    private function validateRelationship(TutorAlumnoRelation $relationship, ?string $otraRelacion): void
    {
        if ($relationship === TutorAlumnoRelation::OTRA && empty($otraRelacion)) {
            throw new \InvalidArgumentException("Debe especificar la relación cuando selecciona 'Otra'.");
        }

        if ($relationship !== TutorAlumnoRelation::OTRA && $otraRelacion !== null) {
            throw new \InvalidArgumentException("El campo 'otra relación' solo aplica cuando la relación es 'Otra'.");
        }
    }
}
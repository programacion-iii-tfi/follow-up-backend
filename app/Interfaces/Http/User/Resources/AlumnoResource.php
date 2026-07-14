<?php

namespace App\Interfaces\Http\User\Resources;

use App\Domain\User\Entities\Alumno;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Alumno
 */
class AlumnoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var Alumno $alumno */
        $alumno = $this->resource;

        return [
            'id'                  => $alumno->id()->value(),
            'first_name'          => $alumno->firstName(),
            'last_name'           => $alumno->lastName(),
            'dni'                 => $alumno->dni(),
            'username'            => $alumno->username(),
            'curso_division'      => $alumno->cursoDivisionTurno()->__toString(),
            'fecha_nacimiento'    => $alumno->fechaNacimiento()->toDisplay(),
            'role'                => $alumno->role()->value,
        ];
    }
}
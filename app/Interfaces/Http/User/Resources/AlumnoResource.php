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
            'telephone'           => $alumno->telephone(),
            'address'             => $alumno->address(),
            'username'            => $alumno->username(),
            'education_level'     => $alumno->educationLevel(),
            'anio_ingreso'        => $alumno->anioIngreso(),
            'role'                => $alumno->role()->value,
        ];
    }
}
<?php

namespace App\Interfaces\Http\User\Resources;

use App\Domain\User\Entities\Docente;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Docente
 */
class DocenteResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var Docente $docente */
        $docente = $this->resource;

        return [
            'id'                  => $docente->id()->value(),
            'first_name'          => $docente->firstName(),
            'last_name'           => $docente->lastName(),
            'dni'                 => $docente->dni(),
            'telephone'           => $docente->telephone(),
            'username'            => $docente->username(),
            'fecha_ingreso'       => $docente->fechaIngreso()->toDisplay(),
        ];
    }
}
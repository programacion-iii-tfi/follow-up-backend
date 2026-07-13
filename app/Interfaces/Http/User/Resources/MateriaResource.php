<?php

namespace App\Interfaces\Http\User\Resources;

use App\Domain\User\Entities\Materia;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Materia
 */
class MateriaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var Materia $materia */
        $materia = $this->resource;

        return [
            'id'                  => $materia->id(),
            'nombre'              => $materia->nombre(),
            'descripcion'         => $materia->descripcion(),
            'turno'               => $materia->turno()->value,
        ];
    }
}
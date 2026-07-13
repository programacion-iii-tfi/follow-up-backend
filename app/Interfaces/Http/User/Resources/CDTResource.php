<?php

namespace App\Interfaces\Http\User\Resources;

use App\Domain\User\Entities\CursoDivisionTurno;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin CursoDivisionTurno
 */
class CDTResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var CursoDivisionTurno $cursoDivisionTurno */
        $cursoDivisionTurno = $this->resource;

        return [
            'id'                  => $cursoDivisionTurno->id(),
            'curso'               => $cursoDivisionTurno->curso(),
            'division'            => $cursoDivisionTurno->division(),
            'turno'               => $cursoDivisionTurno->turno()->value,
            'capacidad_maxima'    => $cursoDivisionTurno->capacidadMaxima(),
        ];
    }
}
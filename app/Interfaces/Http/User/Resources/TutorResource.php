<?php

namespace App\Interfaces\Http\User\Resources;

use App\Domain\User\Entities\Tutor;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Tutor
 */
class TutorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var Tutor $tutor */
        $tutor = $this->resource;

        return [
            'id'                  => $tutor->id()->value(),
            'first_name'          => $tutor->firstName(),
            'last_name'           => $tutor->lastName(),
            'dni'                 => $tutor->dni(),
            'telephone'           => $tutor->telephone() ?? '',
            'email'               => $tutor->email()?->value() ?? '',
        ];
    }
}
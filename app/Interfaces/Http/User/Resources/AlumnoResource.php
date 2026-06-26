<?php

namespace App\Interfaces\Http\User\Resources;

use App\Domain\User\Entities\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 */
class AlumnoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var User $user */
        $user = $this->resource;
        return [
            'id'    => $user->id()->value(),
            'firstName'  => $user->firstName(),
            'lastName' => $user->lastName(),
            'dni' => $user->dni(),
            'role' =>   $user->role()->value,
        ];
    }
}
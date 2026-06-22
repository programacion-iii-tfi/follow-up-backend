<?php

namespace App\Interfaces\Http\User\Resources;

use App\Domain\User\Entities\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 */
class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var User $user */
        $user = $this->resource;
        return [
            'id'    => $user->id()->value(),
            'name'  => $user->name()->value(),
            'email' => $user->email()->value(),
            'role' =>   $user->role()->value,
        ];
    }
}
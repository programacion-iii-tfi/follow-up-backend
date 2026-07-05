<?php

namespace App\Infrastructure\User\Persistence;

use App\Domain\User\ValueObjects\UserRole;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class UserModel extends Authenticatable
{
    use HasApiTokens, HasUuids;

    protected $table = 'users';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'dni',
        'telephone',
        'address',
        'password',
        'role',
        'must_change_password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password'             => 'hashed',
            'role'                 => UserRole::class,
            'must_change_password' => 'boolean',
        ];
    }
}
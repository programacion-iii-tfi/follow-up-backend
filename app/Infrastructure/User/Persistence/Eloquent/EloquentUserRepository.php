<?php

namespace App\Infrastructure\User\Persistence\Eloquent;

use App\Domain\User\Entities\User;
use App\Domain\User\Repositories\UserRepositoryInterface;
use App\Domain\User\ValueObjects\UserEmail;
use App\Domain\User\ValueObjects\UserId;
use App\Domain\User\ValueObjects\UserRole;
use App\Infrastructure\User\Persistence\UserModel;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function save(User $user): User
    {
        $model = UserModel::updateOrCreate(
            ['id' => $user->id()->value()],
            [
                'first_name'           => $user->firstName(),
                'last_name'            => $user->lastName(),
                'dni'                  => $user->dni(),
                'telephone'            => $user->telephone(),
                'address'              => $user->address(),
                'password'             => $user->password(),
                'role'                 => $user->role()->value,
                'must_change_password' => $user->mustChangePassword(),
            ]
        );

        return $this->toDomain($model);
    }

    public function findByEmail(UserEmail $email): ?User
    {
        $model = UserModel::where('email', $email->value())->first();

        return $model ? $this->toDomain($model) : null;
    }

    public function findByUsername(string $username, UserRole $role): ?User
    {
        $table = match ($role) {
            UserRole::ALUMNO => 'alumnos',
            UserRole::DOCENTE => 'docentes',
            UserRole::ADMINISTRADOR => 'admins',
            default => throw new \InvalidArgumentException(
                "El rol {$role->value} no se autentica por username."
            ),
        };

        $model = UserModel::query()
            ->join($table, "{$table}.user_id", '=', 'users.id')
            ->where("{$table}.username", $username)
            ->select('users.*')
            ->first();

        return $model ? $this->toDomain($model) : null;
    }

    public function findById(UserId $id): ?User
    {
        $model = UserModel::find($id->value());

        return $model ? $this->toDomain($model) : null;
    }

    public function delete(UserId $id): void
    {
        UserModel::destroy($id->value());
    }

    public function all(): array
    {
        return UserModel::all()
            ->map(fn(UserModel $model) => $this->toDomain($model))
            ->toArray();
    }

    private function toDomain(UserModel $model): User
    {
        return new User(
            new UserId($model->id),
            $model->first_name,
            $model->last_name,
            (int) $model->dni,
            $model->telephone,
            $model->address,
            $model->password,
            UserRole::from($model->role->value),
            $model->must_change_password,
        );
    }
}
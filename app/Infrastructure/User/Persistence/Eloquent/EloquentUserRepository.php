<?php

namespace App\Infrastructure\User\Persistence;

use App\Domain\User\Entities\User;
use App\Domain\User\Repositories\UserRepositoryInterface;
use App\Domain\User\ValueObjects\UserEmail;
use App\Domain\User\ValueObjects\UserId;
use App\Domain\User\ValueObjects\UserRole;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function save(User $user): User
    {
        $model = UserModel::updateOrCreate(
            ['id' => $user->id()->value()],
            [
                'first_name' => $user->firstName(),
                'last_name'  => $user->lastName(),
                'dni'        => $user->dni(),
                'telephone'  => $user->telephone(),
                'address'    => $user->address(),
                'password'   => $user->password(),
                'role'       => $user->role(),
                'must_change_password' => $user->mustChangePassword(),
            ]
        );

        return $this->toDomain($model);
    }

    public function findById(UserId $id): ?User
    {
        $model = UserModel::find($id->value());

        return $model ? $this->toDomain($model) : null;
    }

    public function findByEmail(UserEmail $email): ?User
    {
        $model = UserModel::where('email', $email->value())->first();

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
            $model->dni,
            $model->telephone,
            $model->address,
            $model->password,
            UserRole::from($model->role),
            $model->must_change_password
        );
    }
}
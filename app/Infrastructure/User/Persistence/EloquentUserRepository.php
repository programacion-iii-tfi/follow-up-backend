<?php

namespace App\Infrastructure\User\Persistence;

use App\Application\User\DTOs\GetUserDTO;
use App\Domain\User\Entities\User;
use App\Domain\User\Repositories\UserRepositoryInterface;
use App\Domain\User\ValueObjects\UserEmail;
use App\Domain\User\ValueObjects\UserId;
use App\Domain\User\ValueObjects\UserName;
use App\Domain\User\ValueObjects\UserRole;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function save(User $user): User
    {
        $model = UserModel::updateOrCreate(
            ['id' => $user->id()->value()],
            [
                'name'     => $user->name()->value(),
                'email'    => $user->email()->value(),
                'password' => $user->password(),
                'role'     => $user->role()->value,  // ← value, no label()
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
            id:       new UserId((string) $model->id),
            name:     new UserName($model->name),
            email:    new UserEmail($model->email),
            password: $model->password,
            role:     $model->role,
        );
    }
}
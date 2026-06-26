<?php

namespace App\Infrastructure\User\Persistence;

use App\Domain\User\Entities\Alumno;
use App\Domain\User\Repositories\AlumnoRepositoryInterface;
use App\Domain\User\ValueObjects\UserId;
use App\Domain\User\ValueObjects\UserName;

class EloquentAlumnoRepository implements AlumnoRepositoryInterface
{
    public function save(Alumno $user): Alumno
    {
        $model = AlumnoModel::updateOrCreate(
            ['id' => $user->id()->value()],
            [
                'first_name' => $user->firstName(),
                'last_name' => $user->lastName(),
                'dni' => $user->dni(),
                'telephone' => $user->telephone(),
                'address' => $user->address(),
                'password' => $user->password(),
                'role' => $user->role()->value,
                'must_change_password' => $user->mustChangePassword(),
            ]
        );

        return $this->toDomain($model);
    }

    public function findById(UserId $id): ?Alumno
    {
        $model = AlumnoModel::find($id->value());

        return $model ? $this->toDomain($model) : null;
    }

    public function findByUsername(string $username): ?Alumno
    {
        $model = AlumnoModel::where('username', $username)->first();

        return $model ? $this->toDomain($model) : null;
    }

    public function all(): array
    {
        return AlumnoModel::all()
            ->map(fn(AlumnoModel $model) => $this->toDomain($model))
            ->toArray();
    }

    public function delete(UserId $id): void
    {
        AlumnoModel::destroy($id->value());
    }

    private function toDomain(AlumnoModel $model): Alumno
    {
        return new Alumno(
            new UserId($model->id),
            $model->first_name,
            $model->last_name,
            $model->dni,
            $model->telephone,
            $model->address,
            $model->password,
            new UserName($model->username),
            $model->anio_ingreso,
            $model->codigo_institucional,
            $model->must_change_password
        );
    }
}
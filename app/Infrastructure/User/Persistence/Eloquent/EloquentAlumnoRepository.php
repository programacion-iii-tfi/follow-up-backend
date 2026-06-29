<?php

namespace App\Infrastructure\User\Persistence;

use App\Domain\User\Entities\Alumno;
use App\Domain\User\Repositories\AlumnoRepositoryInterface;
use App\Domain\User\ValueObjects\UserId;
use App\Domain\User\ValueObjects\UserName;

class EloquentAlumnoRepository implements AlumnoRepositoryInterface
{
    public function save(Alumno $alumno): Alumno
    {
        $userModel = UserModel::updateOrCreate(
            ['id' => $alumno->id()->value()],
            [
                'first_name'           => $alumno->firstName(),
                'last_name'            => $alumno->lastName(),
                'dni'                  => $alumno->dni(),
                'telephone'            => $alumno->telephone(),
                'address'              => $alumno->address(),
                'password'             => $alumno->password(),
                'role'                 => $alumno->role()->value,
                'must_change_password' => $alumno->mustChangePassword(),
            ]
        );

        $alumnoModel = AlumnoModel::updateOrCreate(
            ['user_id' => $userModel->id],
            [
                'username'              => $alumno->username(),
                'nivel_educativo'       => $alumno->educationLevel(),
                'anio_ingreso'          => $alumno->anioIngreso(),
                'codigo_institucional'  => $alumno->codigoInstitucional(),
            ]
        );

        return $this->toDomain($userModel, $alumnoModel);
    }

    public function findById(UserId $id): ?Alumno
    {
        $userModel = UserModel::find($id->value());

        if (!$userModel) return null;

        $alumnoModel = AlumnoModel::where('user_id', $userModel->id)->first();

        return $alumnoModel ? $this->toDomain($userModel, $alumnoModel) : null;
    }

    public function findByUsername(string $username): ?Alumno
    {
        $alumnoModel = AlumnoModel::where('username', $username)->first();

        if (!$alumnoModel) return null;

        $userModel = UserModel::find($alumnoModel->user_id);

        return $userModel ? $this->toDomain($userModel, $alumnoModel) : null;
    }

    public function all(): array
    {
        return AlumnoModel::with('user')
            ->get()
            ->map(fn(AlumnoModel $model) => $this->toDomain($model->user, $model))
            ->toArray();
    }

    public function delete(UserId $id): void
    {
        // cascadeOnDelete en la migración se encarga de borrar alumnos también
        UserModel::destroy($id->value());
    }

    private function toDomain(UserModel $userModel, AlumnoModel $alumnoModel): Alumno
    {
        return new Alumno(
            new UserId($userModel->id),
            $userModel->first_name,
            $userModel->last_name,
            $userModel->dni,
            $userModel->telephone,
            $userModel->address,
            $userModel->password,
            $alumnoModel->username,
            $alumnoModel->anio_ingreso,
            $alumnoModel->codigo_institucional,
            $alumnoModel->educational_level
        );
    }
}
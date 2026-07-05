<?php

namespace App\Infrastructure\User\Persistence\Eloquent;

use App\Domain\User\Entities\Alumno;
use App\Domain\User\Repositories\AlumnoRepositoryInterface;
use App\Domain\User\ValueObjects\CodigoInstitucional;
use App\Domain\User\ValueObjects\UserId;
use App\Domain\User\ValueObjects\UserName;
use App\Infrastructure\User\Persistence\AlumnoModel;
use App\Infrastructure\User\Persistence\UserModel;

class EloquentAlumnoRepository implements AlumnoRepositoryInterface
{
    public function save(Alumno $alumno): Alumno
    {
        $userModel = UserModel::updateOrCreate(
            ['id' => $alumno->id()->value()],
            [
                'first_name'           => $alumno->firstName(),
                'last_name'            => $alumno->lastName(),
                'password'             => $alumno->password(),
                'dni'                  => $alumno->dni(),
                'telephone'            => $alumno->telephone(),
                'address'              => $alumno->address(),
                'role'                 => $alumno->role()->value,
                'must_change_password' => $alumno->mustChangePassword(),
            ]
        );

        $alumnoModel = AlumnoModel::updateOrCreate(
            ['user_id' => $userModel->id],
            [
                'username'              => $alumno->username(),
                'education_level'       => $alumno->educationLevel(),
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

    public function destroy(UserId $id): void
    {
        // cascadeOnDelete en la migración se encarga de borrar alumnos también
        UserModel::destroy($id->value());
    }

    private function toDomain(UserModel $userModel, AlumnoModel $alumnoModel): Alumno
    {
        return new Alumno(
            id:                   new UserId($userModel->id),
            first_name:           $userModel->first_name,
            last_name:            $userModel->last_name,
            password:             $userModel->password,
            dni:                  (int) $userModel->dni,
            telephone:            $userModel->telephone,
            address:              $userModel->address,
            username:             UserName::fromString($alumnoModel->username),
            anio_ingreso:         (int) $alumnoModel->anio_ingreso,
            codigo_institucional: CodigoInstitucional::fromString($alumnoModel->codigo_institucional),
            education_level:      $alumnoModel->education_level,
        );
    }
}
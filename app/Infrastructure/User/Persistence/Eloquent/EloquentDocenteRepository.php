<?php

namespace App\Infrastructure\User\Persistence;

use App\Domain\Shared\ValueObjects\FechaFormateada;
use App\Domain\User\Entities\Docente;
use App\Domain\User\Repositories\DocenteRepositoryInterface;
use App\Domain\User\ValueObjects\UserId;

class EloquentDocenteRepository implements DocenteRepositoryInterface
{
    public function save(Docente $docente): Docente
    {
        $userModel = UserModel::updateOrCreate(
            ['id' => $docente->id()->value()],
            [
                'first_name'           => $docente->firstName(),
                'last_name'            => $docente->lastName(),
                'dni'                  => $docente->dni(),
                'telephone'            => $docente->telephone(),
                'address'              => $docente->address(),
                'password'             => $docente->password(),
                'role'                 => $docente->role()->value,
                'must_change_password' => $docente->mustChangePassword(),
            ]
        );

        $docenteModel = DocenteModel::updateOrCreate(
            ['user_id' => $userModel->id],
            [
                'username'      => $docente->username(),
                'fecha_ingreso' => $docente->fechaIngreso()->toDatabase(),
            ]
        );

        return $this->toDomain($userModel, $docenteModel);
    }

    public function findById(UserId $id): ?Docente
    {
        $userModel = UserModel::find($id->value());

        if (!$userModel) return null;

        $docenteModel = DocenteModel::where('user_id', $userModel->id)->first();

        return $docenteModel ? $this->toDomain($userModel, $docenteModel) : null;
    }

    public function findByUsername(string $username): ?Docente
    {
        $docenteModel = DocenteModel::where('username', $username)->first();

        if (!$docenteModel) return null;

        $userModel = UserModel::find($docenteModel->user_id);

        return $userModel ? $this->toDomain($userModel, $docenteModel) : null;
    }

    public function all(): array
    {
        return DocenteModel::with('user')
            ->get()
            ->map(fn(DocenteModel $model) => $this->toDomain($model->user, $model))
            ->toArray();
    }

    public function delete(UserId $id): void
    {
        // cascadeOnDelete en la migración se encarga de borrar docentes también
        UserModel::destroy($id->value());
    }

    private function toDomain(UserModel $userModel, DocenteModel $docenteModel): Docente
    {
        return new Docente(
            new UserId($userModel->id),
            $userModel->first_name,
            $userModel->last_name,
            $userModel->dni,
            $userModel->telephone,
            $userModel->address,
            $userModel->password,
            $docenteModel->username,
            FechaFormateada::fromDatabase($docenteModel->fecha_ingreso),
        );
    }
}
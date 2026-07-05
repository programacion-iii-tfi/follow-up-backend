<?php

namespace App\Infrastructure\User\Persistence\Eloquent;

use App\Domain\User\Entities\Tutor;
use App\Domain\User\Repositories\TutorRepositoryInterface;
use App\Domain\User\ValueObjects\UserId;
use App\Infrastructure\User\Persistence\TutorModel;
use App\Infrastructure\User\Persistence\UserModel;

class EloquentTutorRepository implements TutorRepositoryInterface
{
    public function save(Tutor $tutor): Tutor
    {
        $userModel = UserModel::updateOrCreate(
            ['id' => $tutor->id()->value()],
            [
                'first_name'           => $tutor->firstName(),
                'last_name'            => $tutor->lastName(),
                'dni'                  => $tutor->dni(),
                'telephone'            => $tutor->telephone(),
                'address'              => $tutor->address(),
                'password'             => $tutor->password(),
                'role'                 => $tutor->role()->value,
                'must_change_password' => $tutor->mustChangePassword(),
            ]
        );

        $tutorModel = TutorModel::updateOrCreate(
            ['user_id' => $userModel->id],
            [
                'email'         => $tutor->email(),
                'relacion'      => $tutor->relationship(),
                'otra_relacion' => $tutor->otraRelacion()
            ]
        );

        return $this->toDomain($userModel, $tutorModel);
    }

    public function findById(UserId $id): ?Tutor
    {
        $userModel = UserModel::find($id->value());

        if (!$userModel) return null;

        $tutorModel = TutorModel::where('user_id', $userModel->id)->first();

        return $tutorModel ? $this->toDomain($userModel, $tutorModel) : null;
    }

    public function findByUsername(string $username): ?Tutor
    {
        $tutorModel = TutorModel::where('username', $username)->first();

        if (!$tutorModel) return null;

        $userModel = UserModel::find($tutorModel->user_id);

        return $userModel ? $this->toDomain($userModel, $tutorModel) : null;
    }

    public function all(): array
    {
        return TutorModel::with('user')
            ->get()
            ->map(fn(TutorModel $model) => $this->toDomain($model->user, $model))
            ->toArray();
    }

    public function delete(UserId $id): void
    {
        // cascadeOnDelete en la migración se encarga de borrar docentes también
        TutorModel::destroy($id->value());
    }

    private function toDomain(UserModel $userModel, TutorModel $tutorModel): Tutor
    {
        return new Tutor(
            new UserId($userModel->id),
            $userModel->first_name,
            $userModel->last_name,
            (int) $userModel->dni,
            $userModel->telephone,
            $userModel->address,
            $userModel->password,
            $tutorModel->email,
            $tutorModel->relacion,
            $tutorModel->otra_relacion
        );
    }
}
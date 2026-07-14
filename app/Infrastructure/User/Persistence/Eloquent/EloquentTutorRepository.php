<?php

namespace App\Infrastructure\User\Persistence\Eloquent;

use App\Domain\User\Entities\Tutor;
use App\Domain\User\Repositories\TutorRepositoryInterface;
use App\Domain\User\ValueObjects\UserEmail;
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
                'password'             => $tutor->password(),
                'telephone'            => $tutor->telephone(),
                'role'                 => $tutor->role()->value,
                'must_change_password' => $tutor->mustChangePassword(),
            ]
        );

        $tutorModel = TutorModel::updateOrCreate(
            ['id' => $userModel->id],
            [
                'email'         => $tutor->email()?->value(),
                'telephone'     => $tutor->telephone()
            ]
        );

        return $this->toDomain($userModel, $tutorModel);
    }

    public function findById(UserId $id): ?Tutor
    {
        $userModel = UserModel::find($id->value());

        if (!$userModel) return null;

        $tutorModel = TutorModel::where('id', $userModel->id)->first();

        return $tutorModel ? $this->toDomain($userModel, $tutorModel) : null;
    }

    public function findByDni(int $dni): ?Tutor
    {
        $userModel = UserModel::where('dni', $dni)->first();

        if (!$userModel) return null;

        $tutorModel = TutorModel::where('id', $userModel->id)->first();

        return $tutorModel ? $this->toDomain($userModel, $tutorModel) : null;
    }

    public function findByUsername(string $username): ?Tutor
    {
        $tutorModel = TutorModel::where('username', $username)->first();

        if (!$tutorModel) return null;

        $userModel = UserModel::find($tutorModel->id);

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

    public function totalTutores(): int
    {
        return TutorModel::count();
    }

    private function toDomain(UserModel $userModel, TutorModel $tutorModel): Tutor
    {
        return new Tutor(
            new UserId($userModel->id),
            $userModel->first_name,
            $userModel->last_name,
            (int) $userModel->dni,
            $tutorModel->telephone,
            $tutorModel->email
                ? new UserEmail($tutorModel->email)
                : null
        );
    }
}
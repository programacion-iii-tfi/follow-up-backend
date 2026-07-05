<?php

namespace App\Infrastructure\User\Persistence\Eloquent;

use App\Domain\User\Entities\Admin;
use App\Domain\User\Repositories\AdminRepositoryInterface;
use App\Domain\User\ValueObjects\UserId;
use App\Infrastructure\User\Persistence\AdminModel;
use App\Infrastructure\User\Persistence\UserModel;
use Illuminate\Support\Facades\DB;

class EloquentAdminRepository implements AdminRepositoryInterface
{
    public function save(Admin $admin): Admin
    {
        return DB::transaction(function () use ($admin) {
            $userModel = UserModel::updateOrCreate(
                ['id' => $admin->id()->value()],
                [
                    'first_name'           => $admin->firstName(),
                    'last_name'            => $admin->lastName(),
                    'password'             => $admin->password(),
                    'role'                 => $admin->role()->value,
                    'must_change_password' => $admin->mustChangePassword(),
                ]
            );

            $adminModel = AdminModel::updateOrCreate(
                ['user_id' => $userModel->id],
                ['username' => $admin->username()]
            );

            return $this->toDomain($userModel, $adminModel);
        });
    }

    public function findById(UserId $id): ?Admin
    {
        $userModel = UserModel::find($id->value());

        if (!$userModel) return null;

        $adminModel = AdminModel::where('user_id', $userModel->id)->first();

        return $adminModel ? $this->toDomain($userModel, $adminModel) : null;
    }

    public function findByUsername(string $username): ?Admin
    {
        $adminModel = AdminModel::where('username', $username)->first();

        if (!$adminModel) return null;

        $userModel = UserModel::find($adminModel->user_id);

        return $userModel ? $this->toDomain($userModel, $adminModel) : null;
    }

    public function all(): array
    {
        return AdminModel::with('user')
            ->get()
            ->map(fn(AdminModel $model) => $this->toDomain($model->user, $model))
            ->toArray();
    }

    public function delete(UserId $id): void
    {
        // cascadeOnDelete en la migración se encarga de borrar docentes también
        UserModel::destroy($id->value());
    }

    private function toDomain(UserModel $userModel, AdminModel $adminModel): Admin
    {
        return new Admin(
            new UserId($userModel->id),
            $userModel->first_name,
            $userModel->last_name,
            $userModel->password,
            $adminModel->username
        );
    }
}
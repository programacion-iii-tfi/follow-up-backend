<?php

namespace App\Infrastructure\User\Persistence\Eloquent;

use App\Domain\User\Entities\Materia;
use App\Domain\User\Repositories\DocenteRepositoryInterface;
use App\Domain\User\Repositories\MateriaRepositoryInterface;
use App\Domain\User\ValueObjects\TurnoEscolar;
use App\Domain\User\ValueObjects\UserId;
use App\Infrastructure\User\Persistence\MateriaModel;

class EloquentMateriaRepository implements MateriaRepositoryInterface
{
    public function __construct(
        private readonly DocenteRepositoryInterface $docenteRepository,
    ) {}

    public function save(Materia $materia): Materia
    {
        $model = MateriaModel::updateOrCreate(
            ['id' => $materia->id() ?: null],
            [
                'nombre'      => $materia->nombre(),
                'descripcion' => $materia->descripcion(),
                'turno'       => $materia->turno()->value,
                'docente_id'  => $materia->docente()->value(),
            ]
        );

        return $this->toDomain($model);
    }

    public function findById(int $id): ?Materia
    {
        $model = MateriaModel::find($id);

        return $model ? $this->toDomain($model) : null;
    }

    public function findByNombre(string $nombre): ?Materia
    {
        $model = MateriaModel::where('nombre', $nombre)->first();

        return $model ? $this->toDomain($model) : null;
    }

    public function all(): array
    {
        return MateriaModel::all()
            ->map(fn (MateriaModel $model) => $this->toDomain($model))
            ->toArray();
    }

    public function destroy(int $id): void
    {
        MateriaModel::destroy($id);
    }

    private function toDomain(MateriaModel $model): Materia
    {
        $docente = $this->docenteRepository->findById(new UserId($model->docente_id));

        if ($docente === null) {
            throw new \RuntimeException(
                "Materia {$model->id} referencia un docente inexistente (integridad referencial rota)."
            );
        }

        return new Materia(
            id: $model->id,
            nombre: $model->nombre,
            descripcion: $model->descripcion,
            turno: TurnoEscolar::from($model->turno),
            docente: $docente->id(),
        );
    }
}
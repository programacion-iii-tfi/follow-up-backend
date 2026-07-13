<?php

namespace App\Domain\User\Repositories;

use App\Domain\User\Entities\Materia;

interface MateriaRepositoryInterface
{
    public function save(Materia $materia): Materia;
    public function findById(int $id): ?Materia;
    public function findByNombre(string $nombre): ?Materia;
    public function all(): array;
    public function destroy(int $id): void;
}
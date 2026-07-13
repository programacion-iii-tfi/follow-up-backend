<?php

namespace App\Infrastructure\User\Persistence;

use Illuminate\Database\Eloquent\Model;

class MateriaModel extends Model
{
    protected $table = 'materias';

    protected $fillable = [
        'nombre',
        'descripcion',
        'turno',
        'docente_id',
    ];

    public function docente()
    {
        return $this->belongsTo(DocenteModel::class, 'docente_id', 'id');
    }
}
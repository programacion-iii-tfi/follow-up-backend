<?php

namespace App\Infrastructure\User\Persistence;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AlumnoModel extends Model
{
    use HasUuids;

    protected $table = 'alumnos';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'user_id',
        'username',
        'education_level',
        'anio_ingreso',
        'codigo_institucional',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, 'user_id');
    }

    public function tutores(): BelongsToMany
    {
        return $this->belongsToMany(TutorModel::class, 'tutor_alumno', 'alumno_id', 'tutor_id');
    }
}
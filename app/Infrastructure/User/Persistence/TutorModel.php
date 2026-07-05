<?php

namespace App\Infrastructure\User\Persistence;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Domain\User\ValueObjects\TutorAlumnoRelation;

class TutorModel extends Model
{
    use HasUuids;

    protected $table = 'tutores';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'user_id',
        'email',
        'relationship',
        'otra_relacion',
    ];

    protected function casts(): array
    {
        return [
            'relationship' => TutorAlumnoRelation::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, 'user_id');
    }

    public function alumnos(): BelongsToMany
    {
        return $this->belongsToMany(
            AlumnoModel::class,
            'tutor_alumno',
            'tutor_id',
            'alumno_id'
        )->withTimestamps();
    }
}
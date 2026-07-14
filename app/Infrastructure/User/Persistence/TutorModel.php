<?php

namespace App\Infrastructure\User\Persistence;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class TutorModel extends Model
{
    use HasUuids;

    protected $table = 'tutores';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'telephone',
        'email',
    ];

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'id', 'id');
    }

    public function tutorAlumnos()
    {
        return $this->hasMany(TutorAlumnoModel::class, 'tutor_id', 'id');
    }
}
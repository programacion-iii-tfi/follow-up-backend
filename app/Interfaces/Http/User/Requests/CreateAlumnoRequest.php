<?php

namespace App\Interfaces\Http\User\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAlumnoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name'           => ['required', 'string', 'max:255'],
            'last_name'            => ['required', 'string', 'max:255'],
            'dni'                  => ['required', 'string', 'unique:users,dni'],
            'telephone'            => ['required', 'string', 'max:20'],
            'address'              => ['required', 'string', 'max:255'],
            'legajo'               => ['required', 'string', 'unique:alumnos,legajo'],
            'carrera'              => ['required', 'string', 'max:255'],
            'año_ingreso'          => ['required', 'integer', 'min:2000', 'max:' . date('Y')],
        ];
    }
}
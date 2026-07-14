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
            // Datos del alumno
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'dni' => ['required', 'integer', 'digits_between:7,8'],
            'fecha_nacimiento' => ['required', 'string', 'max:12'],
            'curso_division_turno_id' => ['required', 'integer', 'exists:curso_division_turno,id'],

            // Relación con el tutor
            'relationship' => ['required', 'string'],
            'otra_relacion' => ['nullable', 'string', 'required_if:relationship,OTRA'],

            // Tutor
            'tutor_id' => ['nullable', 'uuid'],
            'tutor_first_name' => ['nullable', 'string', 'max:100', 'required_if:tutor_id,null'],
            'tutor_last_name' => ['nullable', 'string', 'max:100', 'required_if:tutor_id,null'],
            'tutor_dni' => ['required', 'integer', 'digits_between:7,8'],
            'tutor_telephone' => ['nullable', 'string', 'max:20', 'required_if:tutor_id,null'],
        ];
    }

    public function messages(): array
    {
        return [
            'curso_division_turno_id.exists' => 'El curso/división/turno seleccionado no existe.',
            'otra_relacion.required_if' => 'Debe especificar la relación cuando selecciona "Otra".',
            'tutor_first_name.required_if' => 'El nombre del tutor es obligatorio si no se seleccionó un tutor existente.',
            'tutor_last_name.required_if' => 'El apellido del tutor es obligatorio si no se seleccionó un tutor existente.',
            'tutor_telephone.required_if' => 'El teléfono del tutor es obligatorio si no se seleccionó un tutor existente.',
        ];
    }
}
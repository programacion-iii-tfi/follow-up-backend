<?php

namespace App\Interfaces\Http\User\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTutorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'codigo_institucional' => ['required', 'string', 'max:50'],
            'email'                => ['required', 'string', 'email', 'max:255', 'unique:tutores,email'],
            'password'             => ['required', 'string', 'min:8'],
        ];
    }
}
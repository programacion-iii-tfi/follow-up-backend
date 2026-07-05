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
            'first_name'          => ['required', 'string', 'max:255'],
            'last_name'           => ['required', 'string', 'max:255'],
            'dni'                 => ['required', 'integer', 'unique:users,dni'],
            'telephone'           => ['required', 'string', 'max:20'],
            'address'             => ['required', 'string', 'max:255'],
            'user_email'          => ['required', 'string', 'max:255'],
            'relacion'            => ['required', 'string', 'max:10'],
            'otra_relacion'       => ['required', 'string', 'max:50'],
        ];
    }
}
<?php

namespace App\Interfaces\Http\User\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCDTRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'curso'          => ['required', 'string', 'max:5'],
            'division'       => ['required', 'string', 'max:5'],
            'turno'          => ['required', 'string', 'max:20'],
        ];
    }
}
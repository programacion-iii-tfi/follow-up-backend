<?php

namespace App\Interfaces\Http\User\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateAdminRequest extends FormRequest
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
            'username'            => ['required', 'string', Rule::unique('admins', 'username')],
            'password'            => ['required', 'string', 'min:8']
        ];
    }
}
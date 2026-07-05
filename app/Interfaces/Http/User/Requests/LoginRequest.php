<?php

namespace App\Interfaces\Http\User\Requests;

use App\Domain\User\ValueObjects\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LoginRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'username'    => ['required', 'string'],
            'password' => ['required', 'string'],
            'role'     => ['required', Rule::in(array_column(UserRole::cases(), 'value'))]
        ];
    }
}
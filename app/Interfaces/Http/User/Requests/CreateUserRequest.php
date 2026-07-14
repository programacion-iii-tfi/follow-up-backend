<?php
namespace App\Interfaces\Http\User\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Domain\User\ValueObjects\UserRole;

class CreateUserRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:50',
            'last_name'  => 'required|string|max:50',
            'password'   => 'required|min:8',
            'role'       => ['sometimes', 'string', 'in:' . implode(',', array_column(UserRole::cases(), 'value'))],
        ];
    }
}
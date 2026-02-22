<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{

    public function authorize(): bool
    {
        // TODO: Implement restrictions
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|'.Rule::unique('users')->ignore($this->route('user')),
            'password' => 'nullable|string|min:6|max:255',
            'is_admin' => 'nullable|boolean'
        ];
    }
}

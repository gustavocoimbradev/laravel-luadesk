<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUSerRequest extends FormRequest
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
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|max:255'
        ];
    }
}

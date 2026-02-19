<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DestroyUserRequest extends FormRequest
{

    public function authorize(): bool
    {
        // TODO: Implement restrictions
        return true;
    }


    public function rules(): array
    {
        return [];
    }
}

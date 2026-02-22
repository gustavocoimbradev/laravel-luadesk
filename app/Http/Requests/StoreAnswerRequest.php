<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnswerRequest extends FormRequest
{
  
    public function authorize(): bool
    {
        return $this->user()->id === ($this->route('ticket')->user_id) || $this->user()->is_admin;
    }

    public function prepareForValidation()
    {
       $this->merge([
        'closes_ticket' => $this->closes_ticket ?? false
       ]);
    }

    public function rules(): array
    {
        return [
            'content' => 'required|string|min:5|max:50000|not_regex:/<script/i',
            'closes_ticket' => 'bool'
        ];
    }
}

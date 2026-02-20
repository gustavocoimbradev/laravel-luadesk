<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShowTicketRequest extends FormRequest
{

    public function authorize(): bool
    {
        return $this->user()->id === ($this->route('ticket'))->user_id;
    }

    public function rules(): array
    {
        return [];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTicketRequest extends FormRequest
{
  
    public function authorize(): bool
    {
        $ticket = $this->route('ticket');
        return $this->user()->id === $ticket->user_id;
    }

    public function rules(): array
    {
        return [
            'title'     => 'required|string|max:500',
            'content'   => 'required|string'
        ];
    }
}

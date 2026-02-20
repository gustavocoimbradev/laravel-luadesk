<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{

    use HasFactory;
    
    protected $fillable = ['content', 'ticket_id', 'user_id'];

    public function ticket() {
        return $this->belongsTo(Ticket::class);
    }

}

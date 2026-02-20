<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{

    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'content', 'user_id', 'is_admin'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function answers() {
        return $this->hasMany(Answer::class);
    }

    public function scopeViewedBy($query, $user) {
        return auth()->user()->is_admin ? $query : $query->where('user_id', $user->id);
    }

}

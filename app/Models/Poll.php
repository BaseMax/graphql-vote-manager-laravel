<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function options(){
        return $this->hasMany(PollOption::class);
    }

    public function votes(){
        return $this->hasMany(PollVote::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }
}

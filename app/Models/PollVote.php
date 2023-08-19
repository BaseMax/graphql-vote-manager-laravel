<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PollVote extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function poll(){
        return $this->belongsTo(Poll::class);
    }

    public function pollOption(){
        return $this->belongsTo(PollOption::class);
    }
}
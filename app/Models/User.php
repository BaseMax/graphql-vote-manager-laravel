<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = [];

    public function polls(){
        return $this->hasMany(Poll::class);
    }

    public function votes(){
        return $this->hasMany(PollVote::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function surveys(){
        return $this->hasMany(Survey::class);
    }

    public function responses(){
        return $this->hasMany(SurveyResponse::class);
    }
}

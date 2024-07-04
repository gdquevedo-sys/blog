<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use  HasFactory, Notifiable;
    
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

   
    protected $hidden = [
        'password',
        'remember_token',
    ];

    
    protected $casts = [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];

        //Relación de uno a uno (user-profile)
        public function profile(){
            return $this->hasOne(Profile::class);
        }

        //Relación de uno a muchos (user-article)
        public function articles(){
            return $this->hasMany(Article::class);
        }

        //Relación de uno a muchos (user-comment)
        public function comments(){
            return $this->hasMany(Comment::class);
        }
}


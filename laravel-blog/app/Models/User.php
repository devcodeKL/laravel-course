<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // define a one to many relationship between the User model and Post model
    public function posts()
    {   
        // hasMany() is an Eloquent method used to define a one-to-many relationship
        // This tells Laravel which model to associate with the 'User' model
        return $this->hasMany('App\Models\Post');
    }
    
    public function likes()
    {
        return $this->hasMany('App\Models\PostLike');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\PostComment');
    }
}

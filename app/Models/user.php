<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class user extends Authenticatable
{
    use HasApiTokens, Notifiable;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

   
     
    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function getAuthPassword()
    {
        return $this->password;
    }
    public $timestamps = false;

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}

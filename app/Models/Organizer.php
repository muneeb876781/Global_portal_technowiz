<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Organizer extends Authenticatable
{
    protected $fillable = ['username', 'email', 'password', 'last_login'];

    protected $hidden = ['password', 'remember_token'];
}
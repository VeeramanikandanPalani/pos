<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authendicable;


class User extends Authendicable
{
    use HasFactory;
    // protected $table='users';
}

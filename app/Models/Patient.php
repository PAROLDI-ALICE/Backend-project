<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Patient extends Authenticatable
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $fillable = [
        'lastname',
        'firstname',
        'phoneNumber',
        'email',
        'address',
        'age',
        'needs',
        'additional_information',
        'description'
    ];
    protected $hidden = [
        'password'
    ];

}
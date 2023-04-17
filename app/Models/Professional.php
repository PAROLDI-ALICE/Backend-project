<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Professional extends Authenticatable
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $fillable = [
        'lastname',
        'firstname',
        'email',
        'password',
        'phoneNumber',
        'profession',
        'city',
        'profession',
        'experienceYears',
        'experienceDetails',
        'description',
        'skills',
        'price',
        'diplomas',
        'languages'
    ];
// protected $hidden = [
//     'password'
// ];
}
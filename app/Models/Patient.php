<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;

class Patient extends Authenticatable
{
    use HasFactory, Notifiable, CanResetPassword;
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
        'description',
        'password'
    ];
    public function routeNotificationForMail()
    {
        return $this->email;
    }
}
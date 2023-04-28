<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable, CanResetPassword;
    protected $guarded = ['id'];
    public function routeNotificationForMail()
    {
        return $this->email;
    }
}

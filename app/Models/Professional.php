<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;

class Professional extends Authenticatable
{
    use HasFactory, Notifiable, CanResetPassword;
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
    public function setCategoryAttribute($value)
    {
        $this->attributes['skills'] = json_encode($value);
    }
    public function getCategoryAttribute($value)
    {
        return $this->attributes['category'] = json_decode($value);
    }
    public function routeNotificationForMail()
    {
        return $this->email;
    }
}
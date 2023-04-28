<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $fillable = [
        'date' => 'date_format:d/m/Y',
        'time' => 'time',
    ];
    public function setCategoryAttribute($event)
    {
        $this->attributes['events'] = json_encode($event);
    }
    public function getCategoryAttribute($value)
    {
        return $this->attributes['events'] = json_decode($value);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $guarded=[];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }  
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
    public function serviceProvider()
    {
        return $this->belongsTo(ServiceProvider::class,'service_provider_id');
    }


    use HasFactory;
}
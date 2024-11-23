<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    // use HasFactory;
    use Notifiable;
    protected $guarded = [];
    public function appointments()
{
    return $this->hasMany(Appointment::class, 'customer_id');
}

}

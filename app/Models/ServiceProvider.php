<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceProvider extends Model
{
    protected $guarded=[];
    public function services()
    {
        return $this->hasMany(Service::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    

    use HasFactory;
}

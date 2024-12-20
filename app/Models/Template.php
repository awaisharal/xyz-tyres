<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;
    protected $guarded=[];
    //users realatiom(shopkeeper)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

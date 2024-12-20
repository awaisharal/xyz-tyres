<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $casts = [
        'date' => 'date', // Casts the date as a Carbon instance
        'start_time' => 'datetime:H:i', // Cast start_time as a Carbon instance
        'end_time' => 'datetime:H:i', // Cast end_time as a Carbon instance
        'is_full_day' => 'boolean',
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Support\Carbon\Carbon;

use Carbon;
class Appointment extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function dateTime()
{
    return Carbon::parse($this->date . ' ' . $this->time);
}
}

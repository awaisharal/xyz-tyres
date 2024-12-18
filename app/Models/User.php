<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::saving(function ($user) {
            // Generate the slug from the company name
            $slug = Str::slug($user->company);

            // Check if slug already exists and make it unique by appending a number
            $count = User::where('company_slug', 'like', "$slug%")->count();
            $user->company_slug = $count > 0 ? "$slug-" . ($count + 1) : $slug;
        });
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'user_id');
    }
    //templates
    public function templates()
    {
        return $this->hasMany(Template::class);
    }






}

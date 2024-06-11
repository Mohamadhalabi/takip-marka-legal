<?php

namespace App\Models;

use App\Notifications\CustomResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_email_verified',
        'keyword_limit',
        'plan_id',
        'subscription_ends_on',
        'landscape_limit',
        'search_limit',
        'remaining_landscape_search_limit',
        'remaining_bulletin_search_limit',
        'language',
    ];

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

    public function keywords()
    {
        return $this->hasMany(Keyword::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function userActivities()
    {
        return $this->hasMany(UserActivity::class);
    }

    public function testLimit()
    {
        return $this->hasOne(TestLimit::class);
    }

    public function tour()
    {
        return $this->hasOne(Tour::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPassword($token));
    }

    /**
     * Get the images for the user.
     *
     * @return void
     */
    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
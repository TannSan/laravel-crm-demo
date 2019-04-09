<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name', 'email', 'password'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime'];

    /**
     * Get the URL to the user's avatar image.
     *
     * @return string   URL to the user's avatar image or the default image.
     */
    public function getAvatarUrlAttribute()
    {
        return url(is_null($this->avatar) ? '/img/user_default.png' : 'storage/img/' . $this->avatar);
    }
}

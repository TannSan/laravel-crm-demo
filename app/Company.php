<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Company extends Model
{
    use Notifiable;

    protected $fillable = ['name', 'email', 'website', 'logo'];
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Get the URL to the company's logo image.
     *
     * @return string   URL to the company's logo image or the default image.
     */
    public function getLogoUrlAttribute()
    {
        return url('storage/img/' . ($this->logo ?? 'company_default.png'));
    }

    /**
     * Get a collection of company names keyed by their id.
     */
    public static function list() {
        return Company::all()->pluck('name', 'id')->sort();
    }
}

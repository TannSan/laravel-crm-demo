<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Employee extends Model
{
    use Notifiable;

    protected $fillable = ['company_id', 'firstname', 'lastname', 'email', 'phone'];
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Get the full name
     *
     * @return string   Firstname and lastname concatinated
     */
    public function getNameAttribute()
    {
        return trim($this->firstname . ' ' . $this->lastname);
    }

    /**
     * Get the company name for where this employee works
     *
     * @return string   Get the company name for where this employee works
     */
    public function getCompanyNameAttribute()
    {
        return $this->company_id === null ? null : \App\Company::find($this->company_id)->name;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'city',
        'state',
        'zip_code',
        'country',
        'street',
        'code_id'
    ];
    public function invoice()
    {
        return $this->hasOne('App\Models\Invoice');
    }
    public function code()
    {
        return $this->belongsTo('App\Models\CountryCode');
    }
}

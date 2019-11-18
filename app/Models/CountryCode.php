<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CountryCode extends Model
{
    protected $table = 'country_code';

    protected $fillable = [
        'code'
    ];
    public function customer()
    {
        return $this->hasOne('App\Models\Customer');
    }
}

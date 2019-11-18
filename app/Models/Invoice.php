<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'number',
        'date',
        'tax',
        'tax_rate',
        'total',
        'subtotal',
        'customer_id',
        'city',
        'state',
        'zip_code',
        'country',
        'street'
    ];

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    public function items() {
        return $this->hasMany('App\Models\InvoiceItems');
    }
}

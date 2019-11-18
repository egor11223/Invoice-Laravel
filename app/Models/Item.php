<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'name',
        'price',
        'stock',
    ];

    public function invoiceItems()
    {
        return $this->hasOne('App\Models\InvoiceItems');
    }
}

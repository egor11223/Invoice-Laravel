<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class InvoiceItems extends Model
{
    protected $table = 'invoices_items';

    protected $fillable = [
        'item_id',
        'qty',
        'price',
        'invoice_id'
    ];
    public function invoice()
    {
        return $this->belongsTo('App\Models\Invoice');
    }
    public function item()
    {
        return $this->belongsTo('App\Models\Item');
    }
}

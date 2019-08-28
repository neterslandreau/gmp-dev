<?php

namespace App;

class DeliveryCharge extends Model
{
    protected $table = 'delivery_charges';

    protected $fillable = [
        'invoice_id',
        'store_nbr',
        'invoice_nbr',
        'delivery_date',
        'cost_ext',
        'deferred_bill_date',
        'deferred_bill_flag'
    ];
    public $incrementing = false;

    public function invoice()
    {
        return $this->belongsTo('App\Invoice');
    }
}

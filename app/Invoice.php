<?php

namespace App;

class Invoice extends Model
{
    protected $table = 'invoices';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'store_id'
    ];

    /**
     * Indicates if the ID's are auto-incrementing
     *
     * @var bool
     */
    public $incrementing = false;

    public function store()
    {
        return $this->belongsTo('App\Store');
    }

    public function deliveryCharge()
    {
        return $this->hasOne('App\DeliveryCharge');
    }

    public function billedItem()
    {
        return $this->hasOne('App\BilledItem');
    }

    public function orderExemption()
    {
        return $this->hasOne('App\OrderExemption');
    }

    public function allowance()
    {
        return $this->hasOne('App\Allowance');
    }
    public function invoiceTotal()
    {
        return $this->hasOne('App\InvoiceTotal');
    }

    public function deal()
    {
        return $this->hasOne('App\Deal');
    }
}

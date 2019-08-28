<?php

namespace App;

class OrderExemption extends Model
{
    protected $table = 'order_exemptions';

    protected $fillable = [
        'invoice_id',
        'store-nbr',
        'invoice-nbr',
        'delivery-date',
        'cost-ext',
        'deferred-bill-date',
        'deferred-bill-flag',
        'retail-dept',
        'case-qty-billed',
        'upc-code',
        'facility',
        'whse',
        'item-code-ckdgt-bil',
        'item-code-ckdgt-ord',
        'sub-code',
        'reject-code',
        'item-desc',
        'ba-retail-ext',
        'picking-slot',
        'size',
        'pack',
        'retail-price',
        'retail-pricing-unit',
    ];

    public $incrementing = false;

    public function invoice()
    {
        return $this->belongsTo('App\Invoice');
    }
}

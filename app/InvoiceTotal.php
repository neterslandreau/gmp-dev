<?php

namespace App;

class InvoiceTotal extends Model
{
    protected $table = 'invoice_totals';

    protected $fillable = [
        'invoice_id',
        'store_nbr',
        'invoice_nbr',
        'retail_dept',
        'delivery_date',
        'case_qty_billed',
        'cost_ext',
        'deferred_bill_date',
        'deferred_bill_flag',
        'upc_code',
        'facility',
        'whse',
        'deal_amount',
        'mbr_ext_case_cost',
        'total_fees',
        'total_retail'
    ];
    public $incrementing = false;

    public function invoice()
    {
        return $this->belongsTo('App\Invoice');
    }
}

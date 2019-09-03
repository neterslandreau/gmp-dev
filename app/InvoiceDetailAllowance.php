<?php

namespace App;

class InvoiceDetailAllowance extends Model
{
    protected $table = 'invoice_detail_allowances';

    protected $fillable = [
        'invoice_id',
        'store_nbr',
        'invoice_nbr',
        'delivery_date',
        'cost_ext',
        'deferred_bill_date',
        'deferred_bill_flag',
        'retail_dept',
        'upc_code',
        'facility',
        'whse',
        'item_code_ckdgt_bil',
        'item_code_ckdgt_ord',
        'sub_code',
        'reject_code',
        'item_desc',
        'ba_retail_ext',
        'picking_slot',
        'size',
        'pack',
        'retail_price',
        'retail_pricing_unit',
        'mbr_case_cost',
        'freight',
        'pallet_weight',
        'deal_seqnum',
        'excpt_desc'
    ];

    public $incrementing = false;

    public function invoice()
    {
        return $this->belongsTo('App\Invoice');
    }
}

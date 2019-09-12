<?php

namespace App;

class InvoiceDetail extends Model
{
    protected $table = 'invoice_details';

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
        'item_desc',
        'ba_retail_ext',
        'rwi',
        'picking_slot',
        'size',
        'pack',
        'retail_price',
        'retail_pricing_unit',
        'mbr_case_cost',
        'mbr_ext_case_cost',
        'freight',
        'pallet_weight',
        'order_qty',
        'item_rfnc_cd',
    ];

    public $incrementing = false;

    public function invoice()
    {
        return $this->belongsTo('App\Invoice')->select([
            'invoice_id', 'upc_code', 'pos_description',

            ]);
    }
}

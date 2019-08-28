<?php

namespace App;

class Deal extends Model
{
    protected $table = 'deals';

    protected $fillable = [
        'invoice_id',
        'store_nbr',
        'invoice_nbr',
        'delivery_date',
        'case_qty_billed',
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
        'deal_number',
        'deal_type',
        'promotion_program',
        'start_date',
        'end_date',
        'deal_amount',
        'picking_slot',
        'size',
        'pack',
        'retail_price',
        'retail_pricing_unit',
        'mbr_case_cost',
        'mbr_ext_case_cost',
        'freight',
        'pallet_weight',
        'deal_seqnum',
    ];

    public $incrementing = false;

    public function invoice()
    {
        return $this->belongsTo('App\Invoice');
    }
}

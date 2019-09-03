<?php

namespace App;

class Sales extends Model
{
    public $table = 'sales';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'store_nbr',
        'upc_code',
        'quantity_sold',
        'amount_sold',
        'weight_sold',
        'sale_date',
        'department',
        'enhanced_department',
        'price_qty',
        'price',
        'coupon_type',
        'category',
        'unit_cost',
        'b_value',
        'pos_description',
        'main_link',
        'size',
        'case_cost',
        'wh_item_code',
        'vendor_item_number',
        'price_type',
        'cur_price_qty',
        'cur_price_base',
        'base_unit_cost',
        'base_case_cost',

    ];

}

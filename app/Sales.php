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
        'qty_sold',
        'amt_sold',
        'weight_sold',
        'sale_date',
        'department',
        'enhanced_department',
        'price_qty',
        'price',
        'coupon_type',
        'category',
        'unit_cost',
        'pos_description',
        'size',
        'case_cost',
        'cur_price_qty',
        'cur_price',
        'base_unit_cost',
        'base_case_cost',

    ];
    public $incrementing = false;

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['pos_description','store_nbr','upc_code'],
            ],
        ];
    }

}

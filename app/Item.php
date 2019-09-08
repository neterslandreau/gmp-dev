<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug',
        'store_nbr',
        'upc_code',
        'qty_onhand',
        'qty_sold',
        'amt_sold',
        'weight_sold',
        'sale_date',
        'price_qty',
        'price',
        'unit_cost',
        'pos_description',
        'size',
        'case_cost',
        'cur_price_qty',
        'cur_price',
        'base_unit_cost',
        'base_case_cost',
    ];

    /**
     * Indicates if the ID's are auto-incrementing
     *
     * @var bool
     */
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

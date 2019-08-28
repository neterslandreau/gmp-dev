<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $table = 'purchases';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
//        'slug', 'name', 'upc_code', 'description', 'size', 'quantity', 'net_cost', 'net_case'
    ];

    /**
     * Indicates if the ID's are auto-incrementing
     *
     * @var bool
     */
    public $incrementing = false;
}

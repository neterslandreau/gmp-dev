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
        'slug', 'name', 'upc_code', 'description', 'size', 'quantity', 'net_cost', 'net_case'
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
                'source' => 'description',
            ],
        ];
    }
}

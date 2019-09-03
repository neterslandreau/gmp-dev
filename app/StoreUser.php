<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class StoreUser extends Pivot
{
    public $table = 'store_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'store_id', 'user_id'
    ];

    public $incrementing = false;
}

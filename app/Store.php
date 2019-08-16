<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;

class Store extends Model
{
    use Sluggable;

    public $table = 'stores';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'manager_id', 'slug'
    ];

    public function manager()
    {
        return $this->hasOne('App\User', 'id', 'manager_id');
    }

    public function store_format()
    {
        return $this->hasOne('App\StoreFormat', 'id', 'store_format_id');
    }

}

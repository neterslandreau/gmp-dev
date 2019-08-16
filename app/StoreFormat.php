<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;

class StoreFormat extends Model
{
    use Sluggable;

    protected $table = 'store_formats';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'slug'
    ];

    public function stores()
    {
        return $this->hasMany('App\Store');
    }

}

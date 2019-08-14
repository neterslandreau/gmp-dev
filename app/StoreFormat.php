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
    /**
     * Indicates if the ID's are auto-incrementing
     *
     * @var bool
     */
    public $incrementing = false;

    public function stores()
    {
        return $this->hasMany('App\Store');
    }

}

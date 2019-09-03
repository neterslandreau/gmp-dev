<?php

namespace App;

class Store extends Model
{

    public $table = 'stores';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'manager_id', 'slug', 'number'
    ];

    public function manager()
    {
        return $this->hasOne('App\User', 'id', 'manager_id');
    }

    public function store_format()
    {
        return $this->hasOne('App\StoreFormat', 'id', 'store_format_id');
    }

    public function invoices()
    {
        return $this->hasMany('App\Invoice');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'store_user');
    }

}

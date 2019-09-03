<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Lab404\Impersonate\Models\Impersonate;
use Cviebrock\EloquentSluggable\Sluggable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use Uuids;
    use Impersonate;
    use Sluggable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'last_name', 'first_name', 'role', 'slug'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Indicates if the ID's are auto-incrementing
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Create the slug from first name and last name
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => ['first_name', 'last_name'],
            ],
        ];
    }

    public function manager()
    {
        return $this->belongsTo('App\Store', 'id', 'manager_id');
    }

    public function stores()
    {
        return $this->belongsToMany(Store::class, 'store_user');
    }

}

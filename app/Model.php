<?php namespace App;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Model extends Eloquent
{
    use Uuids;
    use Sluggable;
    use SoftDeletes;

    protected $guarded = [];

    public $incrementing = false;

    protected $dates = ['deleted_at'];

    /**
     * Create the slug from first name and last name
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }
}

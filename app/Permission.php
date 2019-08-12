<?php

namespace App;


class Permission extends Model
{
    protected $table = 'permissions';

    protected $fillable = ['name', 'key', 'controller', 'method'];
}

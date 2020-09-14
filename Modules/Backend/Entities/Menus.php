<?php

namespace Modules\Backend\Entities;

use Illuminate\Database\Eloquent\Model;

class Menus extends Model
{
    protected $table = 'menus';
    protected $fillable = [
        'name'
    ];
}

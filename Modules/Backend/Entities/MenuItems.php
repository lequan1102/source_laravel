<?php

namespace Modules\Backend\Entities;

use Illuminate\Database\Eloquent\Model;

class MenuItems extends Model
{
    protected $table = 'menu_items';
    protected $fillable = [
        'menu_id', 'title', 'url', 'order', 'target', 'icon_class', 'parent_id', 'route', 'parameters'
    ];
}

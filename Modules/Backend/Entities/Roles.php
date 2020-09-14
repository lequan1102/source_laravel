<?php

namespace Modules\Backend\Entities;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $table = 'roles';
    protected $fillable = ['name', 'display_name'];

    public function permissions()
    {
        return $this->belongsToMany('Modules\Backend\Entities\Permissions','permission_role');
    }
    
}     
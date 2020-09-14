<?php

namespace Modules\Backend\Entities;

use Illuminate\Database\Eloquent\Model;
// Sử dụng Translatable
// use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
// use Astrotomic\Translatable\Translatable;

class Settings extends Model
{
    //Sử dụng Translatable
    // use Translatable;
    //Khai báo các trường được dịch
    // public $translatedAttributes = ['title', 'slug', 'body', 'excerpt', 'meta_description', 'meta_keywords' ,'seo_title'];

    protected $table = 'settings';
    protected $fillable = ['key', 'label', 'value', 'element_placeholder', 'type', 'order', 'property', 'group_name'];
    public $timestamps = true;
    /**
     * Relationships [category_id] Posts -> [id] Category
     * 1. hasOne Category.
     * 2.
     */
    public function group(){
        return $this->hasMany('Modules\Backend\Entities\SettingsGroup', 'group_name', 'name');
    }
}

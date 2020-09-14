<?php

namespace Modules\Backend\Entities;

use Illuminate\Database\Eloquent\Model;
// Sử dụng Translatable
// use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
// use Astrotomic\Translatable\Translatable;

class Config extends Model
{
    //Sử dụng Translatable
    // use Translatable;
    //Khai báo các trường được dịch
    // public $translatedAttributes = ['title', 'slug', 'body', 'excerpt', 'meta_description', 'meta_keywords' ,'seo_title'];

    protected $table = 'config';
    protected $fillable = ['name', 'label', 'value'];
    public $timestamps = true;
    /**
     * Relationships [category_id] Posts -> [id] Category
     * 1. hasOne Category.
     * 2.
     */
    
}

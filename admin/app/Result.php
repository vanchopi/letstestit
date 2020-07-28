<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Result extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;

    
    protected $fillable = ['variants'];
    //protected $appends = ['main_image', 'main_image_link', 'bg_image', 'bg_image_link'];
    protected $with = ['media'];
    
}

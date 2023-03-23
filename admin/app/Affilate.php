<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Affilate extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;
    //
    protected $table = 'affilates';
    protected $fillable = ['link', 'description', 'type'];
    protected $appends = ['affilate_image', 'affilate_image_link'];
    protected $with = ['media'];

    public static function storeValidation($request)
    {
        return [
            'link' => 'max:65535|nullable',
            'description' => 'max:65535|nullable',
            'type' => 'max:191|nullable',
            'affilate_image' => 'file|nullable|mimes:jpeg,png,jpg,gif,svg|max:8048',
        ];
    }

    public static function updateValidation($request)
    {
        return [
            'link' => 'max:65535|nullable',
            'description' => 'max:65535|nullable',
            'type' => 'max:191|nullable',
            'affilate_image' => 'nullable'
        ];
    }

    public function getAffilateImageAttribute()
    {
        return $this->getFirstMedia('affilate_image');
    }

    /**
     * @return string
     */
    public function getAffilateImageLinkAttribute()
    {
        $file = $this->getFirstMedia('affilate_image');
        if (! $file) {
            return null;
        }

        return '<a href="' . $file->getUrl() . '" target="_blank">' . $file->file_name . '</a>';
    }
}

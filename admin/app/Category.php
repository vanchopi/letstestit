<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * Class Category
 *
 * @package App
 * @property string $title
 * @property text $description
 * @property string $main_image
*/
class Category extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;

    
    protected $fillable = ['title', 'description', 'url'];
    protected $appends = ['main_image', 'main_image_link'];
    protected $with = ['media'];

    public static function storeValidation($request)
    {
        return [
            'title' => 'max:191|nullable',
            'description' => 'max:65535|nullable',
            'url' => 'max:191|nullable',
            'main_image' => 'file|image|nullable',
        ];
    }

    public static function updateValidation($request)
    {
        return [
            'title' => 'max:191|nullable',
            'description' => 'max:65535|nullable',
            'url' => 'max:191|nullable',
            'main_image' => 'nullable'
        ];
    }

    public function getMainImageAttribute()
    {
        return $this->getFirstMedia('main_image');
    }

    /**
     * @return string
     */
    public function getMainImageLinkAttribute()
    {
        $file = $this->getFirstMedia('main_image');
        if (! $file) {
            return null;
        }

        return '<a href="' . $file->getUrl() . '" target="_blank">' . $file->file_name . '</a>';
    }
    
}

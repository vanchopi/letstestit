<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * Class Test
 *
 * @package App
 * @property string $category
 * @property string $title
 * @property string $main_image
 * @property string $bg_image
*/
class Test extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;

    
    protected $fillable = ['title', 'category_id', 'popularity', 'questions', 'test_type'];
    protected $appends = ['main_image', 'main_image_link', 'bg_image', 'bg_image_link'];
    protected $with = ['media'];
    

    public static function storeValidation($request)
    {
        return [
            'category_id' => 'integer|exists:categories,id|max:4294967295|nullable',
            'title' => 'max:191|nullable',
            'main_image' => 'file|image|nullable',
            'bg_image' => 'file|image|nullable'
        ];
    }

    public static function updateValidation($request)
    {
        return [
            'category_id' => 'integer|exists:categories,id|max:4294967295|nullable',
            'title' => 'max:191|nullable',
            'main_image' => 'nullable',
            'bg_image' => 'nullable'
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

    public function getBgImageAttribute()
    {
        return $this->getFirstMedia('bg_image');
    }

    /**
     * @return string
     */
    public function getBgImageLinkAttribute()
    {
        $file = $this->getFirstMedia('bg_image');
        if (! $file) {
            return null;
        }

        return '<a href="' . $file->getUrl() . '" target="_blank">' . $file->file_name . '</a>';
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id')->withTrashed();
    }
    
    
}

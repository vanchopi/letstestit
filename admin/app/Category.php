<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Category
 *
 * @package App
 * @property string $title
 * @property text $description
*/
class Category extends Model
{
    use SoftDeletes;

    
    protected $fillable = ['title', 'description', 'url'];
    

    public static function storeValidation($request)
    {
        return [
            'title' => 'max:191|nullable',
            'description' => 'max:65535|nullable',
            'url' => 'max:191|nullable',
        ];
    }

    public static function updateValidation($request)
    {
        return [
            'title' => 'max:191|nullable',
            'description' => 'max:65535|nullable',
            'url' => 'max:191|nullable',
        ];
    }

    

    
    
    
}

<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Media;

class CategoriesController extends Controller
{
    protected function getCategoriesList(Request $request)
    {
        /*$categories = [];

        return response()->json($categories);*/
        $categories = Category::with([])->get();
        foreach ($categories as $key=>$cat) {
		    $cat['img'] = self::getMedia($cat->id);
		}
        //$categories['img'] = null;
        return $categories;
    } 

    static public function getMedia($id){
        $img = 'https://via.placeholder.com/255.png';
        $media = Media::select(array('collection_name', 'file_name', 'id'))->where(['model_type' => 'App\Category','model_id' => $id])->first();        

        if (!empty($media)){
            $img = env('CLIENT_URL') . '/storage/images/categories/' . $media->id . '/' . $media->file_name;
        }
                
        return $img;
    }
}

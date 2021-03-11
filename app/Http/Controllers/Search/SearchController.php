<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Test;
use App\Media;
use App\Meta;

class SearchController extends Controller
{
    protected function getSearchResult(Request $request)
    {        
        $tests = [];
        $tests = Test::search($request->search)->paginate(3);
        /*for ($i=0; $i < count($tests->data); $i++) { 
            $media = self::getMedias($tests->data[$i]->id);
            $tests->data[$i]->bg_image = $media->bg_image;
            $tests->data[$i]->main_image = $media->main_image;
            $tests->data[$i]['category_url'] =  self::getCategoryUrl($tests->data[$i]->category_id);
        }*/
        return $tests;
    } 

    static public function getMedias($id){
    	$media = Media::select(array('collection_name', 'file_name', 'id'))->where(['model_type' => 'App\Test','model_id' => $id])->get();
        $item = (object) [
            "bg_image" => $media[0]->id . '/' . $media[0]->file_name,
            "main_image" => $media[1]->id . '/' . $media[1]->file_name,
        ];        
    	return $item;
    }

    static public function getCategoryUrl($id){
        $cat = Category::where('id', $id)->first();
        return $url = $cat->url;
    }    
}

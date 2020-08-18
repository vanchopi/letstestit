<?php

namespace App\Http\Controllers\Tests;

use App\Test;
use App\Media;
use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestsController extends Controller
{
    //
    public function getTestsList(Request $request){
        $tests = [];
        $n = 1;
        $num = $request->category;

        if (!$request->url){
            if($num > 0){
                $tests = self::getTestsListByCategoryId($num, $n);
            }else{
                $tests = Test::all()->orderBy('id', 'DESC')->take($n);
            }
        }else{            
            $tests = self::getTestsListByCategoryUrl($num, $n);            
        }       

        for ($i=0; $i < count($tests); $i++) { 
            $media = self::getMedias($tests[$i]->id);
            $tests[$i]->bg_image = $media->bg_image;
            $tests[$i]->main_image = $media->main_image;
        }
        $response = [
            'tests' => $tests,
            'quantity' => $tests->count(),
            'rnum' => $n,
        ];        
        return $response;
    }

    static public function getMedias($id){
    	$media = Media::select(array('collection_name', 'file_name', 'id'))->where(['model_type' => 'App\Test','model_id' => $id])->get();
        $item = (object) [
            "bg_image" => $media[0]->id . '/' . $media[0]->file_name,
            "main_image" => $media[1]->id . '/' . $media[1]->file_name,
        ];
        //print_r($item);
    	return $item;
    }

    static public function getTestsListByCategoryId($id, $n){                
        return $test = Test::select('*')->where('category_id',$id)->orderBy('id', 'DESC')->take($n)->get();        
    }

    static public function getMoreTestsByCategoryId($catId, $lim, $num){          
        $whereData = [
            ['category_id', $catId],
            ['id', '<', $num],
        ];          
        return $test = Test::where($whereData)
                        ->orderBy('id', 'DESC')
                        ->limit($lim)
                        ->get();
    }

    static public function getTestsListByCategoryUrl($str, $n){        
        $cat = Category::where('url', $str)->first();        
        return $tests = self::getTestsListByCategoryId($cat->id, $n);
    }

    static public function getMoreTestsByCategoryUrl($str, $lim, $num){        
        $cat = Category::where('url', $str)->first();        
        return $tests = self::getMoreTestsByCategoryId($cat->id, $lim, $num);   
    }

    public function getTest($id){
        $test = Test::findOrFail($id);
        //$questions = json_decode($test->questions);
        $bgImage = self::getMedias($id);
        $test->main_image = $bgImage->main_image;
        $test->questions = json_decode($test->questions);
        return $test;
    }
    
    function getMore(Request $request){
        //return 
        $ifUrl = $request->url;
        $num = $request->id;
        $cat = $request->category;
        $lim = 3;
        $tests = [];
        if($request->id > 0){            
            switch (true) {
                case $ifUrl:
                    $tests = self::getMoreTestsByCategoryUrl($cat, $lim, $num);                    
                    break;
                case !$ifUrl:
                    $tests = self::getMoreTestsByCategoryId($cat, $lim, $num);                    
                    break;
                default:
                    $tests = [];
                    break;
            };
        }else{
            /*$tests = DB::table('post')
              ->orderBy('id', 'DESC')
              ->limit(5)
              ->get();
            }*/
            $tests = [];
        }
        $output = '';
        $last_id = '';        
        for ($i=0; $i < count($tests); $i++) { 
            $media = self::getMedias($tests[$i]->id);
            $tests[$i]->bg_image = $media->bg_image;
            $tests[$i]->main_image = $media->main_image;
        }

        if(count($tests) > 0){
            $response = [
                'tests' => $tests,
                'quantity' => $tests->count(),
                'rnum' => $lim,
            ];
        }else{
            $response = [
                'tests' => [],
                'quantity' => 0,
                'rnum' => $lim,
            ];
        }

        return $response;
    }
    
}

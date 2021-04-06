<?php

namespace App\Http\Controllers\Tests;

use App\Test;
use App\Media;
use App\Category;
use App\Meta;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestsController extends Controller
{
    //
    public function getTestsList(Request $request){
        $tests = [];
        $n = 3;
        $num = $request->category;

        if (!$request->url){
            if($num > 0){
                $tests = self::getTestsListByCategoryId($num, $n);
            }elseif ($num == 0) {
                $tests = self::getPopularTests($n);//Test::orderBy('popularity', 'DESC')->orderBy('id', 'DESC')->take($n)->get();
            }else{
                $tests = Test::all()->take($n);
            }
        }else{            
            $tests = self::getTestsListByCategoryUrl($num, $n);            
        }       

        for ($i=0; $i < count($tests); $i++) { 
            $media = self::getMedias($tests[$i]->id);
            $tests[$i]->bg_image = $media->bg_image;
            $tests[$i]->main_image = $media->main_image;
            $tests[$i]['category_url'] = self::getCategoryUrl($tests[$i]->category_id);
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

    static public function getCategoryUrl($id){
        $cat = Category::where('id', $id)->first();
        return $url = $cat->url;
    }

    static public function getQuestionImages($id){
        return $images = Media::select(array('file_name', 'id'))->where(['collection_name' => 'question_image','model_id' => $id])->get();
    }
    static public function getPopularTests($n){
        return $test = Test::orderBy('popularity', 'DESC')->orderBy('id', 'DESC')->take($n)->get();
    }
    static public function getTestsListByCategoryId($id, $n){                
        return $test = Test::select('*')->where('category_id',$id)->orderBy('id', 'DESC')->take($n)->get();        
    }
    static public function getMorePopularTests($lim, $num){
        //$ppt = Test::select('popularity')->where('id', $num)->first();
        return $test = Test::where('id', '<', $num)->orderBy('popularity', 'DESC')->orderBy('id', 'DESC')->limit($lim)->get();;
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
        $arrQuestions = json_decode($test->questions);
        //$questions = json_decode($test->questions);
        $questionImages = self::getQuestionImages($id);        
        $bgImage = self::getMedias($id);
        $test->main_image = $bgImage->main_image;
        //$test->questions = json_decode($test->questions);
        $n = 0;
        if (sizeof($questionImages)){
            for ($i=0; $i <sizeof($arrQuestions) ; $i++) { 
                if ($arrQuestions[$i]->img != null){
                    $arrQuestions[$i]->img = $questionImages[$n]->id . '/' . $questionImages[$n]->file_name;
                    $n++;
                }
            }
        }
        $test->questions = $arrQuestions;
        $test['category_url'] =  self::getCategoryUrl($test->category_id);
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
                    if($cat != 0){
                        $tests = self::getMoreTestsByCategoryId($cat, $lim, $num);
                    }else{
                        $tests = self::getMorePopularTests($lim, $num);
                    }
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
            $tests[$i]['category_url'] =  self::getCategoryUrl($tests[$i]->category_id);
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

    public function getTestMeta(Request $request){
        $id = $request->id;
        $response = null;        
        $meta = Meta::where(['model_type' => 'App\Test','model_id' => $id])->get()->first();
        if ($meta){
            $response = $meta->data;
        }
        return $response;
    }
    
    public function getTopTests(Request $request){ 
    $tests = self::getPopularTests(10);
    for ($i=0; $i < count($tests); $i++) { 
        /*$media = self::getMedias($tests[$i]->id);
        $tests[$i]->bg_image = $media->bg_image;
        $tests[$i]->main_image = $media->main_image;*/
        $tests[$i]['category_url'] = self::getCategoryUrl($tests[$i]->category_id);
    }       
        return $tests;
    }
}

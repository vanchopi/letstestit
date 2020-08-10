<?php

namespace App\Http\Controllers\Tests;

use App\Test;
use App\Media;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestsController extends Controller
{
    //
    public function getTestsList(Request $request){
        $tests = [];
        $num = $request->category;
        if ($num > 0 ){
            $tests = self::getTestsListByCategory($num);
        }else{
        	$tests = Test::all();    	
        }
        for ($i=0; $i < count($tests); $i++) { 
            //echo 'id' . $tests[$i]->id;
            $media = self::getMedias($tests[$i]->id);
            $tests[$i]->bg_image = $media->bg_image;
            $tests[$i]->main_image = $media->main_image;                        
        }
        return $tests;
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

    static public function getTestsListByCategory($id){
        return $test = Test::select('*')->where('category_id',$id)->get();
    }

    public function getTest($id){
        $test = Test::findOrFail($id);
        //$questions = json_decode($test->questions);
        $bgImage = self::getMedias($id);
        $test->main_image = $bgImage->main_image;
        $test->questions = json_decode($test->questions);
        return $test;
    }
}

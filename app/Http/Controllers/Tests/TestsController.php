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
    	$tests = Test::all();
    	//$medias = self::getMedias($tests);
    	for ($i=0; $i < count($tests); $i++) { 
    		//echo 'id' . $tests[$i]->id;
            $media = self::getMedias($tests[$i]->id);
            $tests[$i]->bg_image = $media->bg_image;
            $tests[$i]->main_image = $media->main_image;            
    	}
    	//echo '1' . $medias;
        return $tests;
    }

    static public function getMedias($id){    	
    	$media = Media::select(array('collection_name', 'file_name', 'id'))->where('model_id', $id)->get();        
        $item = (object) [
            "bg_image" => $media[0]->id . '/' . $media[0]->file_name,
            "main_image" => $media[1]->id . '/' . $media[1]->file_name,
        ];
        //print_r($item);
    	return $item;
    }
}

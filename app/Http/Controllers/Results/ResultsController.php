<?php

namespace App\Http\Controllers\Results;

use App\Test;
use App\Media;
use App\Result;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResultsController extends Controller
{
    public function getResult(Request $request){    	    	
    	//$test = Test::findOrFail($id);  
    	$tests = 'Здорова!' . $request->id;   	
    	$img = self::getMedias($request->id);
    	
    	/*for ($i=0; $i < count($tests); $i++) { 
    		
            $media = self::getMedias($tests[$i]->id);
            $tests[$i]->bg_image = $media->bg_image;
            $tests[$i]->main_image = $media->main_image;                        
    	}    	
        return $tests;*/
        $results[] = (object) [
	        "img" => $img[0]->result_image,
	        "result" => 'Ты - Добби!',
	        "description" => 'Судьба была неблагосклонна: твое предназначение — быть на посылках у настоящих волшебников. Но смелость, благородство и вера в добро помогли тебе добиться самого желанного — свободы. Наглядный пример того, что даже один в поле может быть еще каким воином.',
	        "id" => $request->id
	    ];
        return response()->json($results[0]);
    }

    static public function getMedias($id){
    	$media = Media::select(array('collection_name', 'file_name', 'id'))->where(['model_type' => 'App\Test','model_id' => $id, 'collection_name' => 'result_image'])->get();
    	$arr = [];
   		for ($i=0; $i < sizeof($media); $i++) { 
   			$arr[$i] = (object) [
	            "result_image" => $media[$i]->id . '/' . $media[$i]->file_name,	            
	        ];
   		}   		
        //print_r($arr);
        //print_r($item);
    	return $arr;
    }
}

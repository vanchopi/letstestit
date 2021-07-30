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
    	$test = Test::findOrFail($request->id);
    	$type = $test->test_type;
    	//print_r($type);
    	
    	$result = Result::select('variants')->where('test_id',$request->id)->first(); 
    	$result = json_decode($result->variants);
    	$userAnswers = $request->answers;
    	$questions = json_decode($test->questions);
    	//$testAnswers = 
    	$img = self::getMedias($request->id);
        $correct = null;
    	//echo "********";
    	//print_r(json_decode($result->variants));
    	switch ($type) {
		    case 'knowledges':
		        $num = self::checkKnowledges($result, $userAnswers, $questions);
                $correct = $num['correct'];
                $num = $num['num'];
		        break;
		    case 'tree':
		        $num = self::checkTree($result, $userAnswers, $questions);
		        break;		    
		    default:
		       echo "хрен знает чё";
		};
		//echo "********";
        $thumb = (!empty($result[$num]->thumb) ? $result[$num]->thumb : null);

        $results = [
        	"success" => true,
	        "img" => $img[$num]->result_image,
	        "title" => $result[$num]->result,
	        "description" => $result[$num]->description,
	        "id" => $request->id,
            'media'=> $thumb,
            'quote'=>  $result[$num]->result,
            'url'=>  'https://letstestit.ru',
            'hashtags'=> 'letstestit',
            'questions' => sizeof($questions),
            'correct' => $correct,
            'name' => $test->title,
	    ];
	    //print_r($results);
        return response()->json($results);        
    }

    static public function getMedias($id){
    	$media = Media::select(array('collection_name', 'file_name', 'id'))->where(['model_type' => 'App\Test','model_id' => $id, 'collection_name' => 'result_image'])->get();
    	$arr = [];
   		for ($i=0; $i < sizeof($media); $i++) { 
   			$arr[$i] = (object) [
	            "result_image" => $media[$i]->id . '/' . $media[$i]->file_name,	            
	        ];
   		}   		        
    	return $arr;
    }

    static public function checkKnowledges($result, $userAnswers, $testAnswers){
    	//echo "1. ********";
    	//print_r($result);
    	/*echo "2. ********";
    	print_r($userAnswers);
    	echo "3. ********";
    	print_r($testAnswers);*/
    	$error = false;
    	$correct = 0;
    	for ($i=0; $i < sizeof($userAnswers); $i++) { 
    		$id = $userAnswers[$i]['id'];    		
    		if ($testAnswers[$i]->answers[$id]->checked > 0 ){
    			$correct++;
    		}
    	}
    	//echo "result size - " . sizeof($result);
    	$num = sizeof($result);
    	$sortedResult = self::subSort($result, 'value');
    	//echo "--------";
    	//print_r($sortedResult);
    	//echo "--------";
    	$numResult = 0;
    	if ($correct > 0){
	    	if ($num > 1){
	    		if ($correct >= $sortedResult[$num - 1]->value){
	    			$numResult = $sortedResult[$num - 1]->id;
	    			//echo "1.*";
	    		}else{
	    			for ($i=0; $i < $num - 1; $i++) { 
						if ( ($sortedResult[$i]->value <= $correct) && ($correct <= $sortedResult[$i + 1]->value) ){
							$numResult = $sortedResult[$i]->id;
							//echo "2.*";
						}
	    			}
	    		}
		    	
		    } elseif ($num == 1){
		    	$numResult = 0;
		    	//echo "3.*";
		    } else{
		    	//echo " empty ";
		    	$numResult = -1;
		    	//echo "4.*";
		    }
		}else{
			$numResult = 0;
			//echo "5.*";
		}    	
    	return $result = [
            'num' => $numResult,
            'correct' => $correct,
        ];
    }

    static public function subSort($arr, $keyVal){
    	usort($arr, function($a, $b){
		    if( $a->value == $b->value )
		        return 0;
		    else if($a->value > $b->value)
		        return 1;
		    else
		        return -1;
		});
    	return $arr;
    }

    static public function checkTree($result, $userAnswers, $testAnswers){
        $numResult = 0;
        $num = sizeof($result);        
        $signs = [];
        for ($i=0; $i < sizeof($userAnswers); $i++) { 
            $signs[$i] = $userAnswers[$i]['sign']['id'];
        }        
        $unic = array_count_values($signs);
        arsort($unic);
        $keyArr = [];
        $n = 0;
        foreach($unic as $key=>$value){   
            $keyArr[$n] = $key;
            $n++;
        } 
        /*echo "--***--**---***---***--\n";
        print_r($unic);
        echo "--\n";
        print_r($keyArr);
        echo "--" . $keyArr[0] . "--\n";
        echo "--***--**---***---***--\n";*/
        return $keyArr[0];
    }
}

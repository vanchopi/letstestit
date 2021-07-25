<?php

namespace App\Http\Controllers\Api\V1;

use App\Test;
use App\Result;
use App\Meta;
use App\Http\Controllers\Controller;
use App\Http\Resources\Test as TestResource;
use App\Http\Requests\Admin\StoreTestsRequest;
use App\Http\Requests\Admin\UpdateTestsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;

use App\Http\Controllers\Traits\FileUploadTrait;


class TestsController extends Controller
{
    public function index()
    {
        

        return new TestResource(Test::with(['category'])->get());
    }

    public function show($id)
    {        
        if (Gate::denies('test_view')) {
            return abort(401);
        }
        $test = Test::with(['category'])->findOrFail($id);
        $result = json_decode((Result::select('variants')->where('test_id',$id)->first())->variants);
        //$resultsImage = Result::where('test_id', $id)->firstOrFail()->getMedia();
        $resultsImage = [
            'results' =>  $test->getMedia('result_image'),
            'questions' => $test->getMedia('question_image')
        ];
        //$tests = new TestResource($test);
        return $response = [
            'tests' => new TestResource($test),
            'results' => $result,
            'meta' => json_decode((Meta::where(['model_type' => 'App\Test','model_id' => $id])->get()->first())->data),
            'media' => $resultsImage
        ];
        //return new TestResource($test);
    }

    public function store(StoreTestsRequest $request)
    {
        if (Gate::denies('test_create')) { 
            return abort(401);
        }

        $results = $request->variants;
        $questionsImg = $request->qestions_img;
        $seo = $request->seo;
        $thumbs = [];
        $targetFolder = explode( "/admin" , $_SERVER['DOCUMENT_ROOT'] )[0].'/admin/storage/app/public/images/thumbs';
        //$variants = json_decode($results);

        print_r(gettype($request->main_image));

        echo "--------";
        print_r($questionsImg);
        //print_r(hasFile($request->variants[0]['img']));
        //print_r(gettype($request->variants[0]['img']));
        //print_r($seo);        

        echo "********";        
        for ($i=0; $i < sizeof($results) ; $i++) {
            $thumbs[$i] = json_decode($results[$i]['thumb'])->src;            
        }
        echo "********";
        

        //print_r($request->all());

        $test = Test::create($request->all());        
        
        if ($request->hasFile('main_image')) {
            $test->addMedia($request->file('main_image'))->toMediaCollection('main_image', 'cards');
        }if ($request->hasFile('bg_image')) {
            $test->addMedia($request->file('bg_image'))->toMediaCollection('bg_image', 'test_bg');
        }
        for ($i=0; $i < sizeof($results) ; $i++) {
            try{
                $test->addMedia($request->variants[$i]['img'])->toMediaCollection('result_image', 'results');
            } catch (Exception $e){
                echo "shit just happened";
            }
        }

        if($questionsImg != ''){
            for ($i=0; $i < sizeof($questionsImg) ; $i++) {
                try{
                    $test->addMedia($request->qestions_img[$i])->toMediaCollection('question_image', 'questions');
                } catch (Exception $e){
                    echo "shit just happened";  
                }
            }  
        }
        $subFolder = $test->id;
        
        //thumbs
        for ($i=0; $i < sizeof($thumbs) ; $i++) {
            $data = $thumbs[$i];
            if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
                $data = substr($data, strpos($data, ',') + 1);
                $type = strtolower($type[1]); // jpg, png, gif

                if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
                    echo "invalid image type";
                    throw new \Exception('invalid image type');
                }
                $data = str_replace( ' ', '+', $data );
                $data = base64_decode($data);

                if ($data === false) {
                    echo "base64_decode failed";
                    throw new \Exception('base64_decode failed');
                }
            } else {
                echo "did not match data URI with image data";
                throw new \Exception('did not match data URI with image data');
            }

            $path = $targetFolder . "/" . $subFolder;
            $fileName = "thumb" . $subFolder . "-" . $i . ".{$type}";
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            file_put_contents($path . "/". $fileName , $data);

            $results[$i]['thumb'] = $subFolder . "/" . $fileName;
            
        }

        // results
        $result = new Result;
        $result->variants = json_encode($results);
        $result->test_id = $test->id;
        $result->save();

        // meta
        $meta = new Meta;
        $meta->model_type = 'App\Test';
        $meta->model_id = $test->id;
        $meta->data = $seo;
        $meta->save();
        
        return (new TestResource($test))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateTestsRequest $request, $id)// edit
    {
        echo "********";
        print_r($request->all());
        //print_r($request->variants);        
        if (Gate::denies('test_edit')) {
            return abort(401);
        }

        $results = $request->variants;
        $questionsImg = $request->qestions_img;
        $seo = $request->seo;
        $thumbs = [];
        $targetFolder = explode( "/admin" , $_SERVER['DOCUMENT_ROOT'] )[0].'/admin/storage/app/public/images/thumbs';

        for ($i=0; $i < sizeof($results) ; $i++) {
            $thumbs[$i] = json_decode($results[$i]['thumb'])->src;            
        };
        print_r($thumbs);

        $test = Test::findOrFail($id);
        $test->update($request->all());

        if (! $request->input('main_image') && $test->getFirstMedia('main_image')) {
            echo "opa";
        }else{
            echo "!----!";
        }

        // main image && bg image update
        if (! $request->input('main_image') && $test->getFirstMedia('main_image')) {
            $test->getFirstMedia('main_image')->delete();
        }if (! $request->input('bg_image') && $test->getFirstMedia('bg_image')) {
            $test->getFirstMedia('bg_image')->delete();
        }
        if ($request->hasFile('main_image')) {
            $test->addMedia($request->file('main_image'))->toMediaCollection('main_image', 'cards');
        }if ($request->hasFile('bg_image')) {
            $test->addMedia($request->file('bg_image'))->toMediaCollection('bg_image', 'test_bg');
        }

        //results images update 
        for ($i=0; $i < sizeof($results) ; $i++) {
            echo "~~~~~~~\n";
            print_r(gettype($request->variants[$i]['img']));
            echo "~~~~~~~\n";
            print_r($request->variants[$i]['img']);
            /*try{
                $test->addMedia($request->variants[$i]['img'])->toMediaCollection('result_image', 'results');
            } catch (Exception $e){
                echo "shit just happened";
            }*/
        }

        //questions images update
        if($questionsImg != ''){
            for ($i=0; $i < sizeof($questionsImg) ; $i++) {
                echo "-------\n";
                print_r(gettype($request->qestions_img[$i]));
                echo "-------\n";
                print_r($request->qestions_img[$i]);
                /*try{
                    $test->addMedia($request->qestions_img[$i])->toMediaCollection('question_image', 'questions');
                } catch (Exception $e){
                    echo "shit just happened";  
                }*/
            }  
        }

        $subFolder = $test->id;
        
        // results
        $result = Result::where('test_id', $id)->get()->first();
        $rz = json_decode($result->variants);

        //thumbs
        for ($i=0; $i < sizeof($thumbs) ; $i++) {            
            $pos = strpos($thumbs[$i], 'base64');                        
            if($pos !== false){
            //if(true){
                echo "opa----------opa\n";
                print_r($pos);
                $data = $thumbs[$i];
                if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
                    $data = substr($data, strpos($data, ',') + 1);
                    $type = strtolower($type[1]); // jpg, png, gif

                    if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
                        echo "invalid image type";
                        throw new \Exception('invalid image type');
                    }
                    $data = str_replace( ' ', '+', $data );
                    $data = base64_decode($data);

                    if ($data === false) {
                        echo "base64_decode failed";
                        throw new \Exception('base64_decode failed');
                    }
                } else {
                    echo "did not match data URI with image data";
                    throw new \Exception('did not match data URI with image data');
                }

                $nm = $rz[$i]->thumb;
                $path = $targetFolder . "/" . $subFolder;
                $fileName = "thumb" . $subFolder . "-" . $i . ".{$type}";
                $thumbFile = $targetFolder . '/' . $nm;
                unlink($thumbFile);
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                file_put_contents($path . "/". $fileName , $data);

                $results[$i]['thumb'] = $subFolder . "/" . $fileName;
            }else{
                echo "old\n";
                $results[$i]['thumb'] =  explode( "thumbs/" ,  $thumbs[$i])[1];
            }          
        }        
        
        $result->variants = json_encode($results);
        $result->save();

        // meta
        $meta = Meta::where(['model_type' => 'App\Test','model_id' => $id])->get()->first();
        $meta->data = $seo;
        $meta->save();

        /*
        return (new TestResource($test))
            ->response()
            ->setStatusCode(202);*/
        //return $request;
    }

    public function destroy($id) // удаляем: тест, результат, картинки(медиа), мета.
    {
        echo "destroy. ";
        if (Gate::denies('test_delete')) {
            return abort(401);
        }
        $targetFolder = explode( "/admin" , $_SERVER['DOCUMENT_ROOT'] )[0].'/admin/storage/app/public/images/thumbs';
        $path = $targetFolder . "/" . $id;
        $test = Test::findOrFail($id);
        $test->media->each->delete();
        $result = Result::where('test_id', $id)->get()->first();
        //$thumbs = $id . '/' . json_decode($result->variants); надо доделать - удаляем превьюшки 
        $meta = Meta::where(['model_type' => 'App\Test','model_id' => $id])->get()->first();
        if(!$test){
            echo "there is no test. ";
        }else{
            $test->delete();
            $test->forceDelete();   
        }
        if(!$result){
            echo "there is no results. ";
        }else{
            $result->delete();
            $result->forceDelete();
        }
        if(!$meta){
            echo "there is no meta. ";
        }else{
            $meta->delete();
            $meta->forceDelete();
        }
        if (file_exists($path)) {
            $thumb = self::rrmdir($path);
        }
        //$media = self::destroyMedia($id);         

        return response(null, 204);
    }

    static public function destroyMedia($id){        
        return;
    }

    static public function rrmdir($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir."/".$object) == "dir") 
                        rrmdir($dir."/".$object); 
                    else unlink   ($dir."/".$object);
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }
}

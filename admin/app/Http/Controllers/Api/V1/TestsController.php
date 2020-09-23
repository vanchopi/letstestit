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

        return new TestResource($test);
    }

    public function store(StoreTestsRequest $request)
    {
        if (Gate::denies('test_create')) {
            return abort(401);
        }

        //$path = explode("admin", storage_path())[0] . 'public\images\cards';

        /*$path = str_replace('/admin/storage/','',storage_path('public/images/cards'));
        echo '123-' . $path;*/

        $results = $request->variants;
        $questionsImg = $request->qestions_img;
        $seo = $request->seo;
        //$variants = json_decode($results);

        print_r(gettype($request->main_image));

        echo "--------";
        print_r($questionsImg);
        //print_r(hasFile($request->variants[0]['img']));
        //print_r(gettype($request->variants[0]['img']));
        //print_r($seo);

        echo "********";

        print_r($request->all());

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
        for ($i=0; $i < sizeof($questionsImg) ; $i++) {
            try{
                $test->addMedia($request->qestions_img[$i])->toMediaCollection('question_image', 'questions');
            } catch (Exception $e){
                echo "shit just happened";  
            }
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

    public function update(UpdateTestsRequest $request, $id)
    {
        if (Gate::denies('test_edit')) {
            return abort(401);
        }

        $test = Test::findOrFail($id);
        $test->update($request->all());
        
        if (! $request->input('main_image') && $test->getFirstMedia('main_image')) {
            $test->getFirstMedia('main_image')->delete();
        }if (! $request->input('bg_image') && $test->getFirstMedia('bg_image')) {
            $test->getFirstMedia('bg_image')->delete();
        }
        if ($request->hasFile('main_image')) {
            $test->addMedia($request->file('main_image'))->toMediaCollection('main_image');
        }if ($request->hasFile('bg_image')) {
            $test->addMedia($request->file('bg_image'))->toMediaCollection('bg_image');
        }

        return (new TestResource($test))
            ->response()
            ->setStatusCode(202);
    }

    public function destroy($id)
    {
        if (Gate::denies('test_delete')) {
            return abort(401);
        }

        $test = Test::findOrFail($id);
        $test->delete();

        return response(null, 204);
    }
}
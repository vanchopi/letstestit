<?php

namespace App\Http\Controllers\Api\V1;

use App\Test;
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

        $test = Test::create($request->all());        
        
        if ($request->hasFile('main_image')) {
            $test->addMedia($request->file('main_image'))->toMediaCollection('main_image', 'cards');
        }if ($request->hasFile('bg_image')) {
            $test->addMedia($request->file('bg_image'))->toMediaCollection('bg_image', 'test_bg');
        }

        //echo 'id - ' . $test->id;

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

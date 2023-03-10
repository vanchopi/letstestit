<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Test as TestResource;
use App\Http\Requests\Admin\StoreTestsRequest;
use App\Http\Requests\Admin\UpdateTestsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;

use App\Http\Controllers\Traits\FileUploadTrait;


class AffilatesController extends Controller
{
    public function index()
    {
        // return new TestResource(Test::with(['category'])->get());
    }

    public function show($id)
    {        
        
    }

    public function store(StoreTestsRequest $request)
    {
        if (Gate::denies('test_create')) { 
            return abort(401);
        }        

        $test = Test::create($request->all());        
        
        
        
        return (new TestResource($test))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateTestsRequest $request, $id)
    {
        
    }

    public function destroy($id)
    {
        
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

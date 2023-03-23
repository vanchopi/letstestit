<?php

namespace App\Http\Controllers\Api\V1;

use App\Affilate;
use App\Http\Controllers\Controller;
use App\Http\Resources\Affilate as AffilateResource;
use App\Http\Requests\Admin\StoreAffilatesRequest;
use App\Http\Requests\Admin\UpdateAffilatesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;

use App\Http\Controllers\Traits\FileUploadTrait;


class AffilatesController extends Controller
{
    public function index()
    {
        return new AffilateResource(Affilate::with([])->get());
    }

    public function show($id)
    {        
        $affilate = Affilate::with([])->findOrFail($id);

        return new AffilateResource($affilate);
    }

    public function store(StoreAffilatesRequest $request)
    {
        // if (Gate::denies('affilate_create')) { 
        //     return abort(401);
        // }  

        $affilate = Affilate::create($request->all());

        if ($request->hasFile('affilate_image')) {
            $affilate->addMedia($request->file('affilate_image'))->toMediaCollection('affilate_image', 'affilates');
        } 
        
        return (new AffilateResource($affilate))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateAffilatesRequest $request, $id)
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

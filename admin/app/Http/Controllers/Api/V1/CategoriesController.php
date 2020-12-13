<?php

namespace App\Http\Controllers\Api\V1;

use App\Category;
use App\Meta;
use App\Http\Controllers\Controller;
use App\Http\Resources\Category as CategoryResource;
use App\Http\Requests\Admin\StoreCategoriesRequest;
use App\Http\Requests\Admin\UpdateCategoriesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;



class CategoriesController extends Controller
{
    public function index()
    {
        

        return new CategoryResource(Category::with([])->get());
    }

    public function show($id)
    {
        if (Gate::denies('category_view')) {
            return abort(401);
        }

        $category = Category::with([])->findOrFail($id);

        return new CategoryResource($category);
    }

    public function store(StoreCategoriesRequest $request)
    {   
        if (Gate::denies('category_create')) {
            return abort(401);
        }

        $category = Category::create($request->all());
        
        $seo = $request->seo;
        
        //print_r(gettype($request->category_image));
        

        if ($request->hasFile('category_image')) {
            $category->addMedia($request->file('category_image'))->toMediaCollection('category_image', 'categories');
        }

        // meta
        $meta = new Meta;
        $meta->model_type = 'App\Category';
        $meta->model_id = $category->id;
        $meta->data = $seo;
        $meta->save();

        return (new CategoryResource($category))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateCategoriesRequest $request, $id)
    {
        if (Gate::denies('category_edit')) {
            return abort(401);
        }

        $category = Category::findOrFail($id);
        $category->update($request->all());
        
        
         if (! $request->input('category_image') && $category->getFirstMedia('category_image')) {
            $category->getFirstMedia('category_image')->delete();
        }

        return (new CategoryResource($category))
            ->response()
            ->setStatusCode(202);
    }

    public function destroy($id)
    {
        if (Gate::denies('category_delete')) {
            return abort(401);
        }

        $category = Category::findOrFail($id);
        $category->media->each->delete();
        $meta = Meta::where(['model_type' => 'App\Category','model_id' => $id])->get()->first();
        
        if(!$category){
            echo "there is no category. ";
        }else{
            $category->delete();
            $category->forceDelete();   
        }

        if(!$meta){
            echo "there is no meta. ";
        }else{
            $meta->delete();
            $meta->forceDelete();
        }

        return response(null, 204);
    }
}

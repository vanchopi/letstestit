<?php

namespace App\Http\Controllers\Api\V1;

use App\Category;
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
        
        //print_r(gettype($request->main_image));
        

        if ($request->hasFile('main_image')) {
            $category->addMedia($request->file('main_image'))->toMediaCollection('main_image', 'cards');
        }

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
        
        
         if (! $request->input('main_image') && $category->getFirstMedia('main_image')) {
            $category->getFirstMedia('main_image')->delete();
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
        $category->delete();

        return response(null, 204);
    }
}

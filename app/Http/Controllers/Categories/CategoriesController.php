<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;

class CategoriesController extends Controller
{
    protected function getCategoriesList(Request $request)
    {
        /*$categories = [];

        return response()->json($categories);*/
        $categories = Category::with([])->get();
        //print_r($categories);
        return $categories;
    } 
}

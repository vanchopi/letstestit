<?php

namespace App\Http\Controllers\Tests;

use App\Test;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestsController extends Controller
{
    //
    public function getTestsList(Request $request){
    	$tests = Test::all();
        return $tests;
    }
}

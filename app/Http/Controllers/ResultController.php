<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Result;
use DB;

class ResultController extends Controller
{
    public function index()
    {
        $results = Result::with('student')->orderBy('student_id','asc')->get();
        // return $results;
        return view('result.index',compact('results'));
    }
}

<?php

namespace App\Http\Controllers\student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\StudentInfo;
use App\Online_Class;
use Session;
use Helper;

class Online_Class_Controller extends Controller
{
    public function index(){
        try{
		    return view('admin_student.online_class.index');
        }catch(\Throwable $th){
            return $th->getMessage();
        }
    }
    
    public function search(Request $request){
        try{
		    $session = Helper::current_semester();
		    $this_student = StudentInfo::where('Registration_Number', Session::get('student_id'))->first();
		    $classes = Online_Class::where('session', $session)
		                            ->where('class_for', $this_student->Program)
		                            ->where('level_term', $this_student->Current_semester)
		                            ->get();
		    $date = $request->date;
		    return view('admin_student.online_class.index', compact('classes','date'));
        }catch(\Throwable $th){
            return $th->getMessage();
        }
    }
}

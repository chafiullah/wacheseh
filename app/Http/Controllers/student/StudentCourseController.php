<?php

namespace App\Http\Controllers\student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\StudentInfo;
use App\Course;
use App\Department;
use App\Current_Semester_Running;
use App\Syllabus;
use Helper;
use Session;
use DB;

class StudentCourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('student');
    }

    public function index()
    {
    	
    	//return $courses;

    	return view('admin_student.course.home');
    }

    public function course()
    {
        $student = Helper::student_info();
        $dept_id = $student->Program;
        $semester_id = Current_Semester_Running::where('title', $student->Enrollment_Semester)->value('id');
        // return $dept_id.'-'.$semester_id;
        $syllabus_courses = Syllabus::with('course:id,course_code,credit,course_name')->where('department_id',$dept_id)
                                    ->where('session_id',$semester_id)
                                    ->get();
        // return $syllabus_courses;
        return  view('admin_student.course.course',compact('syllabus_courses','student'));
    }

    public function course_fillter($level)
    {
        $id = Session::get('student_id');
        $dept = StudentInfo::select('Program')->where('Registration_Number',$id)->first();
        $courses = DB::table('courses')->where('Program',$dept->Program)->where('levelTerm',$level)
                ->where('status',1)
                ->orderBy('levelTerm','ASC')
                ->get();
        return response()->json( $courses);
    }
}

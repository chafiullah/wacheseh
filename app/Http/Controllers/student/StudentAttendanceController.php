<?php

namespace App\Http\Controllers\student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Course;
use App\StudentInfo;
use App\Registration;
use Illuminate\Support\Facades\Crypt;
use DB;
use Session;
use PDF;

class StudentAttendanceController extends Controller
{
    public function index()
    {
    	$sid = Session::get('student_id');
		$levelTerm = StudentInfo::select('Current_semester')->where('Registration_Number',$sid)->first();
		
    	
    	// $courses = DB::table('courses')->select('id','course_name','course_code')->where('Program',$dept->Program)->get();
    	$session = Registration::select('semester','reg_type','levelTerm','student_id')
                    ->where('student_id',$sid)
                    ->where('levelTerm',$levelTerm->Current_semester)
					->first();
		$courses = DB::table('courses_student')
					->join('courses', 'courses_student.course_id', '=', 'courses.id')
					->select('courses_student.*', 'courses.course_name','courses.course_code','courses.credit')
					->where('courses_student.semester',$session->semester)
					->where('courses_student.student_id',$sid)
					->where('courses_student.reg_type',$session->reg_type)
					->get();
	//return $courses;
    
    	return view('admin_student.attendance.index',compact('courses','session'));
    }

    public function report($c_id)
    {
    	
    	//$c_id = $request->c_id;
    	$sid = Session::get('student_id');
		$levelTerm = StudentInfo::select('Current_semester')->where('Registration_Number',$sid)->first();
    	$session = Registration::select('semester','reg_type','levelTerm','student_id')
                    ->where('student_id',$sid)
                    ->where('levelTerm',$levelTerm->Current_semester)
					->first();
		$courses = DB::table('courses_student')
					->join('courses', 'courses_student.course_id', '=', 'courses.id')
					->select('courses_student.*', 'courses.course_name','courses.course_code','courses.credit')
					->where('courses_student.semester',$session->semester)
					->where('courses_student.student_id',$sid)
					->where('courses_student.reg_type',$session->reg_type)
					->get();
		

    	$co = DB::table('courses')
    					->select('id','course_name','course_code')
    					->where('id',$c_id)
    					->first();

    	$attendances = DB::table('attendances')
    					->select('id','date','present')
    					->where('students_id',$sid)
    					->where('subject_id',$c_id)
    					->orderby('date','desc')
    					->get();
    	return view('admin_student.attendance.index',compact('courses','attendances','co','session'));
	}
	
	public function admit()
	{
		$sid = Session::get('student_id');
		$levelTerm = StudentInfo::select('Current_semester')->where('Registration_Number',$sid)->first();
		
    	
    	// $courses = DB::table('courses')->select('id','course_name','course_code')->where('Program',$dept->Program)->get();
    	$session = Registration::select('semester','reg_type','levelTerm','student_id')
                    ->where('student_id',$sid)
                    ->where('levelTerm',$levelTerm->Current_semester)
					->first();
		$courses = DB::table('courses_student')
					->join('courses', 'courses_student.course_id', '=', 'courses.id')
					->select('courses_student.*', 'courses.course_name','courses.course_code','courses.credit')
					->where('courses_student.semester',$session->semester)
					->where('courses_student.student_id',$sid)
					->where('courses_student.reg_type',$session->reg_type)
					->get();
	
	$clearance= DB::table('clearances_student')
                    ->join('student_infos', 'clearances_student.student_id', '=', 'student_infos.Registration_Number')
                    ->select('clearances_student.*', 'student_infos.Full_Name','student_infos.Registration_Number')
                    ->where('student_infos.Registration_Number',$sid)
					->first();
		
    
    	return view('admin_student.attendance.admit',compact('courses','session','clearance'));
	}

	public function download($sid)
	{
		$sid=Crypt::decrypt($sid);
		$levelTerm = StudentInfo::select('Current_semester','Full_Name','Program','Photo')->where('Registration_Number',$sid)->first();
		
		$session = Registration::select('semester','reg_type','levelTerm','student_id')
                    ->where('student_id',$sid)
                    ->where('levelTerm',$levelTerm->Current_semester)
					->first();
		
		$courses = DB::table('courses_student')
					->join('courses', 'courses_student.course_id', '=', 'courses.id')
					->select('courses_student.*', 'courses.course_name','courses.course_code','courses.credit')
					->where('courses_student.semester',$session->semester)
					->where('courses_student.student_id',$sid)
					->where('courses_student.reg_type',$session->reg_type)
					->get();
					if($levelTerm->Program=='CSE'){
						$department = 'Department of Computer Science and Engineering (CSE)';
					}else if($levelTerm->Program == 'EEE'){
						$department = 'Department of Electrical and Electronic Engineering (EEE)';
					}else if($levelTerm->Program == 'CE'){
						$department = 'Department of Civil  Engineering (CE)';
					}else if($levelTerm->Program == 'BBA'){
						$department = 'Department of Business Administration (DBA)';
					}else if($levelTerm->Program == 'English'){
						$department = 'Department of English';
					}else if($levelTerm->Program == 'LLB'){
						$department = 'Department of Laws';
					}	
		 return view('admin_student.attendance.download',compact('courses','session','levelTerm','department','sid'));

		$data =[
			'courses'=>$courses,
			'session'=>$session,
			'levelTerm'=>$levelTerm,
			'department'=>$department,
			'sid'=>$sid
		];
		$pdf = PDF::loadView('admin_student.attendance.download',$data);  
        return $pdf->download('recepit.pdf');
	}
}

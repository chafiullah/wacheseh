<?php

namespace App\Http\Controllers;

use App\AcademicYear;
use App\Course;
use App\Department;
use App\PromoteStudent;
use App\StudentInfo;
use App\Imports\MarksImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportMarkController extends Controller
{
    public function upload()
    {
        try {
            $classes = Department::all();
            $courses = Course::all();
            $students = StudentInfo::where('status',config('constant.active'))->get();
            $academic_years=AcademicYear::all();
            // return $students;
            return view('mark.import', compact('classes','students','courses','academic_years'));
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    public function generateList(Request $request){
        // return $request;
        try {
            $academic_year_id = AcademicYear::find($request->input('academic_year'))->academic_year;
            $course_id=$request->input('course_id');
            $semester=$request->input('semester');
            $classes = Department::all();
            $courses = Course::all();
            $students = PromoteStudent::with('student:id,name')->where('academic_year',$academic_year_id)->where('department_id',$request->input('class_id'))->get();
            $academic_years=AcademicYear::all();
            return view('mark.import', compact('classes','students','courses','academic_years','course_id','semester'));
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    public function import_mark(Request $request)
    {
        try {
            // return $request;
            Excel::import(new MarksImport, request()->file('file'));
            toastr()->success('Marks uploaded successfully', 'Success');
            return redirect()->route('mark.import.index');
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}

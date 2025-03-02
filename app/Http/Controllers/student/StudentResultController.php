<?php

namespace App\Http\Controllers\student;

use App\Department;
use App\Mark;
use App\PromoteStudent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class StudentResultController extends Controller
{

    public function index()
    {
        try {
            $academic_years=PromoteStudent::where('student_id',auth()->user()->id)->get();
            return view('admin_student.result.result', compact('academic_years'));
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function result($academic_year,$class)
    {
        try {
            $academic_years=PromoteStudent::where('student_id',auth()->user()->id)->get();
            $marks = Mark::where('academic_year', $academic_year)->where('student_id', auth()->user()->id)->where('class_id', $class)->get();
            if ($marks->count() == 0) {
                toastr()->error('No grades were found in the system, please contact administration and address this issue.', 'Grades Missing!');
                return redirect()->back();
            }
            return view('admin_student.result.result', compact('marks','academic_years','academic_year','class'));
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}

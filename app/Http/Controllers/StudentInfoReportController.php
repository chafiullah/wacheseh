<?php

namespace App\Http\Controllers;

use App\Department;
use Illuminate\Http\Request;
use App\StudentInfo;
use DB;

class StudentInfoReportController extends Controller
{
    public function report_dept($deptID)
    {
        try {
            $students = StudentInfo::where('class', $deptID)->get();
            $programs = Department::orderBy('name', 'asc')->get();
            return view('student.index', compact('students', 'programs', 'deptID'));
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}

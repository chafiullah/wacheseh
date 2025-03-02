<?php

namespace App\Http\Controllers\student;

use App\Exam;
use App\PromoteStudent;
use App\StudentExam;
use App\StudentInfo;
use App\Registration;
use App\ProgramOutline;
use App\Http\Controllers\Controller;
use App\Helper\Helper;
use Illuminate\Support\Facades\Session;

class StudentRegistrationController extends Controller
{

  public function enrolledCourses()
  {
    $courses = Registration::with("course")
      ->where("studentID", Session::get("student_id"))
      ->get();
    return view("admin_student.registration.index", compact("courses"));
  }

  public function studentProgramOutline()
  {
    try {
        $student_class=PromoteStudent::where('academic_year',Helper::getActiveAcademicYear()->academic_year)->where('student_id',auth()->user()->id)->first()->department_id;
        $program_outline_courses = ProgramOutline::with("course:id,course_name")
            ->where("class_id", $student_class)
            ->get();
        $exams = Exam::all();
//       return $program_outline_courses;
       return view("admin_student.course.programOutline", compact("program_outline_instruction", "program_outline_courses", "exams"));
    } catch (\Throwable $th) {
      return $th->getMessage();
    }
  }
}

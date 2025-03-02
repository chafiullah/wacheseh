<?php

namespace App\Http\Controllers;

use App\Course;
use App\Department;
use App\Result;
use App\StudentInfo;
use App\Registration;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use App\Imports\EnrollStudentCourse;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Monolog\Registry;

class RegistrationController extends Controller
{
  public function enrollStudentIndex(Department $department)
  {
    try {
      // return $department;
      $courses = Course::all();
      $courses_enrolled = Registration::where("class_id", $department->id)
        ->get();
      return view("registration.index", compact("department", "courses", 'courses_enrolled'));
    } catch (\Throwable $th) {
      return $th->getMessage();
    }
  }

  public function enrollCourses(Request $request, Department $department)
  {
    try {
      foreach ($request->courses as $course) {
        Registration::updateOrCreate([
          'course_id' => $course,
          'class_id' => $department->id
        ]);
      }
      toastr()->success("Students enrolled successfully", "success");
      return redirect()->back();
    } catch (\Throwable $th) {
      return $th->getMessage();
    }
  }

  public function classCourseRemove(Registration $registration)
  {
    try {
      $registration->delete();
      toastr()->success('Subject removed successfully', 'Success');
      return redirect()->back();
    } catch (\Throwable $th) {
      return $th->getMessage();
    }
  }

  /** Assign teachers to courses */
  public function assign_teacher_index($course_id)
  {
    try {
      return $course_id;
    } catch (\Throwable $th) {
      return $th->getMessage();
    }
  }
}

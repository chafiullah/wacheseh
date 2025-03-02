<?php

namespace App\Http\Controllers\Teacher;

use App\Mark;
use App\Course;
use App\Department;
use App\PromoteStudent;
use App\Registration;
use App\Helper\Helper;
use App\TeacherCourse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\StudentInfo;
use Throwable;

class MyCoursesController extends Controller
{
  public function my_courses()
  {
    try {
      $course_profiles = TeacherCourse::where('teacher_id', auth()->user()->id)->get();
      return view('teacher.my_courses.index', compact('course_profiles'));
    } catch (Throwable $th) {
      return $th->getMessage();
    }
  }
  public function grade_book_generate(Department $department, Course $course,$term)
  {
    try {
        $students=PromoteStudent::with('student:id,first_name,last_name,student_id')->where('academic_year',Helper::getActiveAcademicYear()->academic_year)->where('department_id',$department->id)->get();
      // return $students;
      return view('teacher.grades.book', compact('department', 'course', 'students','term'));
    } catch (Throwable $th) {
      return $th->getMessage();
    }
  }
  public function grade_book_courses()
  {
    try {
      return $courses = TeacherCourse::with('course')->where('teacher_id', auth()->user()->id)->get();
      // return view('teacher.grades.courses', compact('courses'));
    } catch (Throwable $th) {
      return $th->getMessage();
    }
  }

  public function grade_book_store(Request $request)
  {
    try {
//       return $request;
      foreach ($request->student_ids as $index => $student_id) {
          if ($request->n1_marks[$index] !=null && $request->n2_marks[$index] !=null){
              $average = ($request->n1_marks[$index] + $request->n2_marks[$index]) / 2;
              $percentage = ($average * 100) / 20;
              $letter_grade = Helper::calculate_grade_letter($percentage);
              Mark::updateOrCreate(
                  [
                      'academic_year' => $request->academic_year,
                      'semester' => $request->semesters[$index],
                      'class_id' => $request->class_id,
                      'student_id' => $student_id,
                      'course_id' => $request->course_id
                  ],
                  [
                      'n1_mark' => $request->n1_marks[$index],
                      'n2_mark' => $request->n2_marks[$index],
                      'grade' => $letter_grade,
                      'signature' => strtoupper($request->signatures[$index]),
                  ]
              );
          }
      }
      toastr()->success('Grades added successfully', 'success');
      return redirect()->back();
    } catch (Throwable $th) {
      return $th->getMessage();
    }
  }

  public function get_grades(Request $request)
  {
    try {
      return $request;
    } catch (Throwable $th) {
      return $th->getMessage();
    }
  }
}

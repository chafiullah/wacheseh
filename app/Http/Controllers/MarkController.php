<?php

namespace App\Http\Controllers;

use App\AcademicYear;
use App\Mark;
use App\Course;
use App\Department;
use App\Helper\Helper;
use App\PromoteStudent;
use App\StudentInfo;
use Illuminate\Http\Request;

class MarkController extends Controller
{
  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    try {
      $classes = Department::all();
      $courses = Course::orderBy("name", "asc")->get();
      $academic_years=AcademicYear::orderBy('academic_year')->get();
      return view("mark.create", compact("courses", 'classes','academic_years'));
    } catch (\Throwable $th) {
      return $th->getMessage();
    }
  }

  public function get_students_by_class(Request $request)
  {
    try {
      $students=PromoteStudent::with('student:id,name,student_id')->where('academic_year',$request->input('academic_year'))->where('department_id',$request->input('class_id'))->get();
      return view('fetched.students_by_class', compact('students'));
    } catch (\Throwable $th) {
      return $th->getMessage();
    }
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    try {
//        return $request;
      foreach ($request->courses as $index => $course) {
        $average = ($request->n1_marks[$index] + $request->n2_marks[$index]) / 2;
        $percentage = ($average * 100) / 20;
        $letter_grade = Helper::calculate_grade_letter($percentage);
        Mark::updateOrCreate(
          [
            'academic_year' => $request->academic_year,
            'semester' => $request->semester,
            'class_id' => $request->class_id,
            'student_id' => $request->student_id,
            'course_id' => $request->courses[$index]
          ],
          [
            'n1_mark' => $request->n1_marks[$index],
            'n2_mark' => $request->n2_marks[$index],
            'grade' => $letter_grade[0],
            'remark' => $letter_grade[1],
            'signature' => strtoupper($request->signatures[$index]),
          ]
        );
      }
      toastr()->success('Grades added successfully', 'Success');
      return redirect()->back();
    } catch (\Throwable $th) {
      return $th->getMessage();
    }
  }
  public function student_marks_index()
  {
    try {
      $classes = Department::all();
      $academic_years=AcademicYear::orderBy('academic_year')->get();
      $students = StudentInfo::orderBy("name", "asc")->get();
      return view('mark.student_marks', compact('students', 'classes','academic_years'));
    } catch (\Throwable $th) {
      return $th->getMessage();
    }
  }

  public function student_marks_show(Request $request)
  {
    try {
//       return $request;
      $student = StudentInfo::find($request->student_id);
      $marks = Mark::where('academic_year', $request->academic_year)
          ->where('semester', $request->semester)
          ->where('student_id', $request->student_id)
          ->where('class_id', $request->class_id)
          ->get();
      return view('mark.student_marks', compact('student', 'marks'));
    } catch (\Throwable $th) {
      return $th->getMessage();
    }
  }
  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Mark  $mark
   * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
   */
  public function edit(Mark $mark)
  {
    try {
      $students = StudentInfo::orderBy("name", "asc")->get();
      $classes = Department::all();
      $courses = Course::orderBy("course_name", "asc")->get();
      $academic_years=AcademicYear::orderBy('academic_year')->get();
      return view("mark.edit", compact("mark", 'students', 'classes', 'courses','academic_years'));
    } catch (\Throwable $th) {
      return $th->getMessage();
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Mark  $mark
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Mark $mark)
  {
    try {
      // return $request;
      $average = ($request->n1_mark + $request->n2_mark) / 2;
      $percentage = ($average * 100) / 20;
      // return $percentage;
      $letter_grade = Helper::calculate_grade_letter($percentage);
      // return $letter_grade;
      $mark->update([
          'academic_year' => $request->academic_year,
          'semester' => $request->semester_id,
          'class_id' => $request->class_id,
          'student_id' => $request->student_id,
          'course_id' => $request->course_id,
          'n1_mark' => $request->n1_mark,
          'n2_mark' => $request->n2_mark,
          'grade' => $letter_grade[0],
          'remark' => $letter_grade[1],
          'signature' => strtoupper($request->signature),
      ]);
      toastr()->success('Grade updated successfully', 'Success');
      return redirect()->route('student-marks.index');
    } catch (\Throwable $th) {
      return $th->getMessage();
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Mark  $mark
   * @return \Illuminate\Http\Response
   */
  public function destroy(Mark $mark)
  {
    try {
      $mark->delete();
      toastr()->success('Mark removed successfully', 'Success');
      return redirect()->route('student-marks.index');
    } catch (\Throwable $th) {
      return $th->getMessage();
    }
  }
  public function get_courses_by_outline(Request $request){
    $academic_year_id = $request->academic_year;
    $class_id = $request->class_id;
    $outlines = \App\Outline::where('class_id', $class_id)->pluck('id')->toArray();
    $desired_outline_id = 0;
    foreach($outlines as $outline){
        $year_outline = \App\OutlineYear::where('outline_id',$outline)->where('academic_year_id',$academic_year_id)->first();
        if(count($year_outline) > 0){
            $desired_outline_id = $year_outline->outline_id;
        }
    }
    $courses = \App\OutlineCourse::with('course')->where('outline_id',$desired_outline_id)->get();
    return view('fetched.courses_by_outline', compact('courses'));
  }

}

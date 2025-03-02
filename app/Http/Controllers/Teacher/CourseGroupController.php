<?php

namespace App\Http\Controllers\Teacher;

use App\CourseGroup;
use App\CourseGroupStudent;
use App\Helper\Helper;
use App\PromoteStudent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Registration;
use App\StudentInfo;

class CourseGroupController extends Controller
{
 public function groups(Request $request)
 {
  try {
   $groups = CourseGroup::where('course_id', $request->course_id)->where('teacher_id', auth()->user()->id)->get();
   if ($groups->count() == 0) {
    $groups = 'none';
   }
   return view('fetched.course_groups', compact('groups'));
  } catch (\Throwable $th) {
   return $th->getMessage();
  }
 }

 public function group_store(Request $request)
 {
  try {
   $check = CourseGroup::where('course_id', $request->course_id)->where('teacher_id', auth()->user()->id)->where('group_name', $request->group_name)->exists();
   if ($check) {
    return response()->json('duplicate');
   } else {
    CourseGroup::create([
     'teacher_id' => auth()->user()->id,
     'course_id' => $request->course_id,
     'group_name' => $request->group_name
    ]);
    return response()->json('success');
   }
  } catch (\Throwable $th) {
   return $th->getMessage();
  }
 }

 public function group_delete(Request $request)
 {
  try {
   CourseGroup::find($request->group_id)->delete();
   return response()->json("success");
  } catch (\Throwable $th) {
   return $th->getMessage();
  }
 }

 public function student_list(Request $request)
 {
  try {
    // return $request;
    $group_id = $request->group_id;
    $class_id = Registration::where('course_id', $request->course_id)->first()->class_id;
    $academic_year=Helper::getActiveAcademicYear()->academic_year;
    $available_students = PromoteStudent::with('student:id,first_name,last_name,student_id')->where('academic_year',$academic_year)->where('department_id',$class_id)->get();
    $students = CourseGroupStudent::with('student')->where('group_id', $request->group_id)->get();
    if ($students->count() == 0) {
        $students = 'none';
    }
    return view('fetched.course_group_students', compact('students', 'available_students', 'group_id'));
  } catch (\Throwable $th) {
    return $th->getMessage();
  }
 }

 public function students_store(Request $request)
 {
  try {
   foreach ($request->students as $student_id) {
    if (!CourseGroupStudent::where('group_id', $request->group_id)->where('student_id', $student_id)->exists()) {
     CourseGroupStudent::create([
      'group_id' => $request->group_id,
      'student_id' => $student_id
     ]);
    }
   }
   return response()->json("success");
  } catch (\Throwable $th) {
   return $th->getMessage();
  }
 }

 public function students_delete(Request $request)
 {
  try {
   CourseGroupStudent::find($request->id)->delete();
   return response()->json('success');
  } catch (\Throwable $th) {
   return $th->getMessage();
  }
 }
}

<?php

namespace App\Http\Controllers\Teacher;

use App\User;
use App\Course;
use App\CourseProfile;
use App\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\TeacherCourse;

class AdminTeacherController extends Controller
{
 public function teachers()
 {
  try {
   $teachers = User::with('roles', 'course_profile')->whereHas('roles', function ($query) {
    $query->where('name', 'teacher');
   })->get();
   return view('teacher.list.list', compact('teachers'));
  } catch (\Throwable $th) {
   return $th->getMessage();
  }
 }

 public function assign_courses_index(User $teacher)
 {
  try {
   $course_profiles = CourseProfile::all();
   $teacher_course_profiles = TeacherCourse::where('teacher_id', $teacher->id)->get();
   return view('teacher.course.assign', compact('course_profiles', 'teacher_course_profiles', 'teacher'));
  } catch (\Throwable $th) {
   return $th->getMessage();
  }
 }

 public function assign_courses_store(Request $request)
 {
  try {
   // return $request;
   foreach ($request->profile_ids as $profile_id) {
    TeacherCourse::create([
     'teacher_id' => $request->teacher_id,
     'profile_id' => $profile_id
    ]);
   }
   toastr()->success('Courses assigned successfulyl!', 'success');
   return redirect()->back();
  } catch (\Throwable $th) {
   return $th->getMessage();
  }
 }

 public function remove_courses_profile(User $teacher)
 {
  try {
   TeacherCourse::where('teacher_id', $teacher->id)->delete();
   toastr()->success('Courses assigned successfulyl!', 'success');
   return redirect()->back();
  } catch (\Throwable $th) {
   return $th->getMessage();
  }
 }
}

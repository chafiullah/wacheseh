<?php

namespace App\Http\Controllers\Report;

use App\Department;
use App\StudentInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CourseReportController extends Controller
{
 public function leftover_index()
 {
  try {
   $programs = Department::select('id', 'short_name')->get();
   return view('report.course.leftover.index', compact('programs'));
  } catch (\Throwable $th) {
   return $th->getMessage();
  }
 }

 public function leftover_student_list(Request $request)
 {
  try {
   $student_list = StudentInfo::select('studentID', 'program_id', 'firstName', 'lastName', 'degreeProgram', 'phone', 'studentSession')->where('academicStatus', 'Current')->where('program_id', $request->program)->where('studentSession', 'like', '%' . $request->year . '%')->orderBy('firstName', 'asc')->get();
   return view('fetched.leftover_students', compact('student_list'));
  } catch (\Throwable $th) {
   return $th->getMessage();
  }
 }

 public function leftover_list(Request $request)
 {
  try {
   $check = in_array('all', $request->student_ids);
   $programs = Department::select('id', 'short_name')->get();
   if ($check) {
    $student_list = StudentInfo::with(['program_outline.course', 'marks' => function ($query) {
     $query->select(['studentID', 'course_id']);
    }])->select('studentID', 'program_id', 'firstName', 'lastName', 'degreeProgram', 'phone', 'studentSession')->where('academicStatus', 'Current')->where('program_id', $request->program)->where('studentSession', 'like', '%' . $request->year . '%')->orderBy('firstName', 'asc')->get();
   } else {
    $student_list = StudentInfo::with(['program_outline.course', 'marks' => function ($query) {
     $query->select(['studentID', 'course_id']);
    }])->select('studentID', 'program_id', 'firstName', 'lastName', 'degreeProgram', 'phone', 'studentSession')->whereIn('studentID', $request->student_ids)->where('academicStatus', 'Current')->where('program_id', $request->program)->where('studentSession', 'like', '%' . $request->year . '%')->orderBy('firstName', 'asc')->get();
   }
   // return $student_list;
   foreach ($student_list as $student) {
    foreach ($student->marks as $mark) {
     $student->program_outline = $student->program_outline->filter(function ($item) use ($mark) {
      return $item->courseID != $mark->course_id;
     });
    }
   }
   // return $student_list;
   return view('report.course.leftover.index', compact('programs', 'student_list'));
  } catch (\Throwable $th) {
   return $th->getMessage();
  }
 }

 public function completed_index()
 {
  try {
   $programs = Department::select('id', 'short_name')->get();
   return view('report.course.completed.index', compact('programs'));
  } catch (\Throwable $th) {
   return $th->getMessage();
  }
 }

 public function completed_list(Request $request)
 {
  try {
   $check = in_array('all', $request->student_ids);
   $programs = Department::select('id', 'short_name')->get();
   if ($check) {
    $student_list = StudentInfo::with(['marks.course'])->select('studentID', 'program_id', 'firstName', 'lastName', 'degreeProgram', 'phone', 'studentSession')->where('academicStatus', 'Current')->where('program_id', $request->program)->where('studentSession', 'like', '%' . $request->year . '%')->orderBy('firstName', 'asc')->get();
   } else {
    $student_list = StudentInfo::with(['marks.course'])->select('studentID', 'program_id', 'firstName', 'lastName', 'degreeProgram', 'phone', 'studentSession')->whereIn('studentID', $request->student_ids)->where('academicStatus', 'Current')->where('program_id', $request->program)->where('studentSession', 'like', '%' . $request->year . '%')->orderBy('firstName', 'asc')->get();
   }
   return view('report.course.completed.index', compact('programs', 'student_list'));
  } catch (\Throwable $th) {
   return $th->getMessage();
  }
 }
}

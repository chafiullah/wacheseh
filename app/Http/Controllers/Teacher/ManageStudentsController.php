<?php

namespace App\Http\Controllers\Teacher;

use App\CourseGroup;
use App\StudentInfo;
use App\TeacherCourse;
use App\CourseGroupStudent;
use Illuminate\Http\Request;
use App\Jobs\SendCustomMailJob;
use App\Http\Controllers\Controller;

class ManageStudentsController extends Controller
{
 public function my_students()
 {
  try {
   $course_profile_courses = TeacherCourse::where('teacher_id', auth()->user()->id)->first()->course_profile->course_profile_courses;
   return view('teacher.my_students.index', compact('course_profile_courses'));
  } catch (\Throwable $th) {
   return $th->getMessage();
  }
 }

 public function send_mail_select_students()
 {
  try {
   $courses = TeacherCourse::with('course.course_groups.group_students.student:studentID,firstName,lastName')->where('teacher_id', auth()->user()->id)->get();
   $student_list = [];
   $students = [];
   foreach ($courses as $item) {
    if (count($item->course->course_groups) > 0) {
     foreach ($item->course->course_groups as $group) {
      if (count($group->group_students) > 0) {
       foreach ($group->group_students as $this_student) {
        // return $this_student;
        $students = [
         "studentID" => $this_student->student->studentID,
         "firstName" => $this_student->student->firstName,
         "lastName" => $this_student->student->lastName
        ];
        // return $students;
        array_push($student_list, $students);
       }
      }
     }
    }
   }
   return view('teacher.email.selectStudent', compact('student_list'));
  } catch (\Throwable $th) {
   return $th->getMessage();
  }
 }

 public function send_mail(Request $request)
 {
  try {
   $students = CourseGroupStudent::where('group_id', $request->student_group_id_for_email)->pluck('student_id');
   foreach ($students as $studentID) {
    $student = StudentInfo::select('studentID', 'ssn', 'firstName', 'lastName', 'email', 'totalTution')->where('studentID', $studentID)->first();
    $details = array(
     'studentName' => $student->firstName . ' ' . $student->lastName,
     'studentID' => $student->studentID,
     'ssn' => $student->ssn,
     'email' => $student->email,
     'totalTution' => $student->totalTution,
     'subject' => $request->subject,
     'body' => $request->body
    );
    // return $details;
    // Mail::to('shuvo.sam2012@gmail.com')->send(new AdminCustomMail($details));
    // return "mail sent";
    $job = (new SendCustomMailJob($details))->delay(now()->addSeconds(60));
    dispatch($job);
   }
   toastr()->success('Mail sent successfully', 'Success');
   return redirect()->back();
  } catch (\Throwable $th) {
   return $th->getMessage();
  }
 }

 public function my_student_remarks($student_db_id, Request $request){
   try{
     $student = StudentInfo::find($student_db_id)->update([
       'remarks'=>$request->remarks
     ]);
     toastr()->success('Remarks updated','Success');
     return redirect()->back();
  }catch (\Throwable $th) {
    return $th->getMessage();
  }
 }
}

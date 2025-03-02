<?php

namespace App\Http\Controllers\student;

use App\Document;
use App\Receivable;
use App\StudentInfo;
use App\StudentNotification;
use App\Current_Semester_Running;
use App\Http\Controllers\Controller;

class StudentHomeController extends Controller
{
  public function home()
  {
    $notifications = StudentNotification::where(
      "studentID",
      auth()->user()->id
    )
      ->where("status", 1)
      ->latest()
      ->get();
			$academic_calender = Current_Semester_Running::with('events.type')->get();
			$admittedStudents = StudentInfo::all();
    return view(
      "admin_student.home.dashboard",
      compact('notifications','academic_calender','admittedStudents')
    );
  }
  public function profile()
  {
    try {
      $student = auth()->user();
      $totalPaid = Receivable::where("studentID", $student->id)
        ->where("responseCode", 1)
        ->sum("amount");
      // return $totalPaid;
      return view(
        "admin_student.profile.profile",
        compact("student", "totalPaid")
      );
    } catch (\Throwable $th) {
      return $th->getMessage();
    }
  }

  public function notificationMarkRead($studentID)
  {
    StudentNotification::where("studentID", $studentID)->update([
      "status" => 2,
    ]);
    return redirect()->back();
  }

  public function notificationAll($studentID)
  {
    $notifications = StudentNotification::where("studentID", $studentID)
      ->latest()
      ->get();
    return view("admin_student.home.allnotification", compact("notifications"));
  }

  public function official_documents()
  {
    try {
      $documents = Document::latest()->get();
      return view("admin_student.Document.index", compact("documents"));
    } catch (\Throwable $th) {
      return $th->getMessage();
    }
  }
}

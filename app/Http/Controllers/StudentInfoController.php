<?php

namespace App\Http\Controllers;

use App\Department;
use App\AcademicYear;
use App\PromoteStudent;
use App\Region;
use App\StudentInfo;
use App\StudentFeature;
use App\Comment;
use App\Helper\Helper;
use App\Outline;
use App\traits\StudentInformation;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Throwable;
use Illuminate\Support\Str;

class StudentInfoController extends Controller
{
    use StudentInformation;
    public function index(){
        try {
          $students = StudentInfo::orderBy("status", "asc")->get();
          $classes = Department::all();
          return view("student.index", compact("students", 'classes'));
        } catch (Throwable $th) {
          return $th->getMessage();
        }
      }
  public function studentview(Request $request)
  {
    $student = StudentInfo::where("studentID", $request->studentID)->first();
    // return $student;
    return view("filter.single_student", compact("student"));
  }

  public function studentDownload($id)
  {
    $student = StudentInfo::where("studentID", $id)->first();

    // return $student;
    //$pdf = PDF::loadView('filter.download');
    //dd($pdf);
    //return $pdf->download('student.pdf');
    return view("filter.download", compact("student"));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    try {
      $classes = Department::all();
      $regions = Region::all();
      return view("student.create", compact("classes", 'regions'));
    } catch (Throwable $th) {
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
         $studentID = Helper::generateStudentUniqueID();
         $request->merge(['student_id' => $studentID]);
         $student = StudentInfo::create($request->except("class","_token", "report_card", "birth_certificate"));
         $student_reforged = Helper::reforgeStudentId($student);
         $student->update([
            'name' => Str::title($student->name),
            'password' => Hash::make('student#'),
            'student_id' => $student_reforged
         ]);
        /**
         * Assigning the student to the class for that academic year
         *
         */
        PromoteStudent::create([
            'academic_year' => Helper::getYear($student->admission_date),
            'student_id' => $student->id,
            'department_id' => $request->input("class"),
            'outline_id'=>0,
        ]);

        if ($request->hasFile('image')) {
              $image = Image::make($request->image);
              $image->resize(150, 150)->encode("png");
              $image_name = $student->id . "_profile_image.png";
              Storage::disk("public")->put(
                  "student_images/" . $image_name,
                  $image
              );
              $student->update([
                  'image' => $image_name,
              ]);
        }


        if ($request->hasFile('report_card')) {
              $academic_report = time() . '_' . $request->name . '_previous_report_card.' . $request->file('report_card')->extension();
              Storage::disk('public')->put('student_admission_documents/' . $academic_report, file_get_contents($request->file('report_card')));
              $student->update([
                  'report_card' => $academic_report,
              ]);
        }


        if ($request->hasFile('birth_certificate')) {
              $birth_certificate = time() . '_' . $request->name . '_birth_certificate.' . $request->file('birth_certificate')->extension();
              Storage::disk('public')->put('student_admission_documents/' . $birth_certificate, file_get_contents($request->file('birth_certificate')));
              $student->update([
                  'birth_certificate' => $birth_certificate,
              ]);
        }
        toastr()->success("Student added successfully!", "Success");
        return redirect()->back();
    } catch (Throwable $th) {
        return $th->getMessage();
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\StudentInfo  $studentInfo
   * @return \Illuminate\Http\Response
   */
  public function show(StudentInfo $studentInfo)
  {
    try {
      return view('student.view', compact('studentInfo'));
    } catch (Throwable $th) {
      return $th->getMessage();
    }
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\StudentInfo  $studentInfo
   * @return \Illuminate\Http\Response
   */
  public function edit(StudentInfo $studentInfo)
  {
    try {
      $classes = Department::all();
      $regions = Region::all();
      $comments = Comment::where('student_database_id',$studentInfo->id)->latest()->get();
      return view("student.edit", compact("studentInfo", "classes", 'regions','comments'));
    } catch (Throwable $th) {
      return $th->getMessage();
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\StudentInfo  $studentInfo
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, StudentInfo $studentInfo)
  {
    try {
      $studentInfo->update($request->except('_mehod', '_token', 'name','image', 'report_card', 'birth_certificate'));
      $studentInfo->update([
        'name' => Str::title($request->name),
      ]);
      if ($request->has('image')) {
        File::delete(config('constant.asset_url') . 'student_images/' . $studentInfo->image);
        $image = Image::make($request->image);
        $image->resize(150, 150)->encode("png");
        $image_name = $studentInfo->id . "_profile_image.png";
        Storage::disk("public")->put(
          "student_images/" . $image_name,
          $image
        );
        $studentInfo->update([
          'image' => $image_name
        ]);
      }
      if ($request->has('report_card')) {
        File::delete(config('constant.asset_url') . 'student_admission_documents/' . $studentInfo->report_card);
        $academic_report = time() . '_' . $request->name . '_previous_report_card.' . $request->file('report_card')->extension();
        Storage::disk('public')->put('student_admission_documents/' . $academic_report, file_get_contents($request->file('report_card')));
        $studentInfo->update([
          'report_card' => $academic_report
        ]);
      }
      if ($request->has('birth_certificate')) {
        File::delete(config('constant.asset_url') . 'student_admission_documents/' . $studentInfo->birth_certificate);
        $birth_certificate = time() . '_' . $request->name . '_birth_certificate.' . $request->file('birth_certificate')->extension();
        Storage::disk('public')->put('student_admission_documents/' . $birth_certificate, file_get_contents($request->file('birth_certificate')));
        $studentInfo->update([
          'birth_certificate' => $birth_certificate
        ]);
      }
      toastr()->success('Information updated successfully', 'Success');
      return redirect()->route('studentInfo.index');
    } catch (Throwable $th) {
      $th->getMessage();
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\StudentInfo  $studentInfo
   * @return \Illuminate\Http\Response
   */
  public function student_password_reset(StudentInfo $studentInfo)
  {
    try {
      $studentInfo->update([
        "password" => Hash::make('student#')
      ]);
      toastr()->info("Password reset to default -> student#", "Success");
      return redirect()->back();
    } catch (Throwable $th) {
      return $th->getMessage();
    }
  }

  public function export_all_filter($type)
  {
    if ($type == "all") {
      $students = StudentInfo::get();
    } elseif ($type == "Active") {
      $students = StudentInfo::where("status", "Active")->get();
    } elseif ($type == "Withdrawn") {
      $students = StudentInfo::where("status", "Withdrawn")->get();
    } elseif ($type == "Expelled") {
      $students = StudentInfo::where("status", "Expelled")->get();
    } else {
      $students = StudentInfo::where("status", "Alumni")->get();
    }
    return view("student.index", compact("students", "type"));
  }

  public function loginAccess($id, $status)
  {
    StudentInfo::where("id", $id)->update([
      "loginAccess" => $status,
    ]);
    toastr()->success("Student profile activated, now student can access to his/her portal");
    return redirect()->back();
  }

  public function featureControlIndex()
  {
    $features = StudentFeature::all();
    return view("portalFeatures.index", compact("features"));
  }

  public function featureControl($featureID)
  {
    $currentStatus = StudentFeature::find($featureID);
    if ($currentStatus->status == 0) {
      StudentFeature::find($featureID)->update([
        "status" => 1,
      ]);
    } else {
      StudentFeature::find($featureID)->update([
        "status" => 0,
      ]);
    }
    toastr()->success("Features Status Updated!", "Success");
    return redirect()->back();
  }

  public function remarksUpdate(Request $request, $studentID)
  {
    try {
      StudentInfo::where("studentID", $studentID)->update([
        "remarks" => $request->remarks,
      ]);
      toastr()->success("Remarks updated successfully", "Success");
      return redirect()->route("mark.sheet");
    } catch (Throwable $th) {
      return $th->getMessage();
    }
  }

  public function attendance_request_form($id)
  {
    try {
      $studentInfo =  StudentInfo::find($id);
      $pdf = PDF::loadView('registration.attendance', ['details' => $studentInfo]);
      // return $pdf->stream();
      return $pdf->download($studentInfo->name . ' ' . $studentInfo->name . ' - attendance-request.pdf');
    } catch (Throwable $th) {
      return $th->getMessage();
    }
  }
  public function indexComment(StudentInfo $studentInfo)
  {
      try {
            $comments = Comment::where('student_database_id',$studentInfo->id)->latest()->get();
            return view("student.edit", compact("studentInfo",'comments'));
      } catch (Throwable $th) {
            return $th->getMessage();
      }
  }
  /**
   * @param Request $request
   * @return Request|string
   */
  public function addComment(Request $request){
    try {
      Comment::create($request->all());
      $comments = Comment::where('student_database_id',$request->student_database_id)->latest()->get();
      return view('fetched.student_comments',compact('comments'));
    } catch (Throwable $th) {
      return $th->getMessage();
    }
  }

  public function deleteComment($id){
    try {
      Comment::destroy($id);
      toastr()->success('Comment has been removed.','Deleted');
      return redirect()->back();
    } catch (Throwable $th) {
      return $th->getMessage();
    }
  }
  public function listByAcademicYear(Request $request){
      try {
          $students=PromoteStudent::with('student:id,name,student_id')->where('academic_year',$request->input('academic_year'))->where('department_id',$request->input('class'))->get();
          return view('promotion.student_list',compact('students','request'));
      }catch (Throwable $th) {
          return $th->getMessage();
      }
  }
  public function studentPromoteStart(){
      try {
          $academic_years=AcademicYear::orderBy('academic_year')->get();
          $students=StudentInfo::where('status','Active')->get();
          $classes=Department::all();
          $outlines = Outline::all();
          return view('promotion.start',compact('academic_years','students','classes', 'outlines'));
      }catch (Throwable $th) {
          return $th->getMessage();
      }
  }

  public function studentPromote(Request $request){
      // return $request; 
      try {
          foreach ($request->input('students') as $student){
            PromoteStudent::updateOrCreate(
              [
                  'academic_year'=>$request->input('academic_year'),
                  'student_id'=>$student,
              ],
              [
                'department_id'=>$request->input('class'),
                'outline_id'=>$request->input('outline')
              ]
            );
          }
          toastr()->success("Student Promoted successfully", "Success");
          return redirect()->back();
      }catch (Throwable $th) {
          return $th->getMessage();
      }
  }

  public function studentPromoteBulk(Request $request){
      try {
        //  return $request;
          $list_of_students_previous_year=PromoteStudent::with('student:id,name,student_id')->where('academic_year',$request->input('from_academic_year'))->where('department_id',$request->input('from_class'))->get();
          // return $list_of_students_previous_year;
          foreach ($list_of_students_previous_year as $student_previous_year){
              PromoteStudent::updateOrCreate(
                  [
                      'academic_year'=>$request->input('to_academic_year'),
                      'student_id'=>$student_previous_year->student_id,
                  ],
                  [
                    'department_id'=>$request->input('to_class'),
                    'outline_id'=>$request->input('outline')
                  ]
              );
          }
          toastr()->success("Student Promoted successfully", "Success");
          return redirect()->back();
      }catch (Throwable $th) {
          return $th->getMessage();
      }
  }

  public function destroyFromListByAcademicYear($id){
      try {
          $archive=PromoteStudent::find($id);
          if($this->checkStudentGradeBook($archive)&&$this->checkStudentPayment($archive)){
              toastr()->error("The system has detected that this student has grades/payments of this academic year in the system. Thus this student cannot be removed from the list. If you think the grades/payments are inaccurate please remove them first or contact the admin.", "Success");
              return redirect()->route('student.promote.start');
          }
          $archive->delete();
          toastr()->success("Student has been removed the academic year list.", "Success");
          return redirect()->route('student.promote.start');
      } catch (Throwable $th) {
          return $th->getMessage();
      }
  }
}

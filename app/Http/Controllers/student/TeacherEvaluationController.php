<?php

namespace App\Http\Controllers\student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\TE_Question_Category;
use App\TE_Question;
use App\Faculty;
use App\Course;
use App\TE_Main;
use App\TE_Marks;
use App\StudentInfo;
use App\Registration;
use App\Current_Semester_Running;
use App\Event;
use Session;
use DB;
use Helper;
class TeacherEvaluationController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('student');
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            
                                /** checking if the student is back registered or current registered **/
            $this_student = Helper::student_info();
            $session = Registration::where('student_id', $this_student->Registration_Number)
                                    ->where('levelTerm', $this_student->Current_semester)
                                    ->whereIn('reg_type', [1,2])
                                    ->latest()
                                    ->first();
            $current_session = Helper::current_semester();
            // return $session;
                                /** checking if the student is back registered or current registered **/
            
                                /** if the student is back registered starts**/
            if($session->semester != $current_session){
                $courses = DB::table('courses')
                            ->join('courses_student','courses.id','=','courses_student.course_id')
                            ->select('courses.course_code','courses.course_name','courses.type','courses_student.student_id','courses_student.course_id','courses_student.reg_type')
                            ->where('courses.type', 'theory')
                            ->where('courses_student.student_id',$this_student->Registration_Number)
                            ->where('courses_student.levelTerm',$this_student->Current_semester)
                            // ->where('semester',$session->semestere)
                            ->whereIn('courses_student.reg_type',array('1','2'))
                            ->get();
                            
                            // return $courses;
                    
                return view('admin_student.teachers_evaluation.index', compact('courses','session'));
            }else{
                    // if the student is current registered
                        
                    $session_id = Current_Semester_Running::where('title',Helper::current_semester())->value('id');
                        // return $session_id;
                    $event = Event::with('type')
                                    ->where('session_id',$session_id)
                                    ->where('type_id','3')
                                    ->first();
                        // return $event;
                    $current_date = \Carbon\Carbon::now()->format('Y-m-d');
                    // return $current_date;
                    $diff = \Carbon\Carbon::parse($current_date)->between(\Carbon\Carbon::parse($event->starts), \Carbon\Carbon::parse($event->ends));
                    if($diff == false){
                        toastr()->error('Timeline does not match Please check the event section.','Error');
                        return redirect()->back();
                    }else{
                        $courses = DB::table('courses')
                                ->join('courses_student','courses.id','=','courses_student.course_id')
                                ->select('courses.course_code','courses.course_name','courses.type','courses_student.student_id','courses_student.course_id','courses_student.reg_type')
                                ->where('courses.type', 'theory')
                                ->where('courses_student.student_id',$this_student->Registration_Number)
                                ->where('courses_student.levelTerm',$this_student->Current_semester)
                                // ->where('semester',$session->semestere)
                                ->whereIn('courses_student.reg_type',array('1','2'))
                                ->get();
                                
                                // return $courses;
                        
                        return view('admin_student.teachers_evaluation.index', compact('courses','session'));
                    }
                    
            }
                                /** if the student is back registered ends**/
        }catch(\Exception $exception){
            return $exception->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($session, $id)
    {
        // return $id;
        $student_id = Session::get('student_id');
        $student = \App\StudentInfo::where('Registration_Number',$student_id)->first();
        $questions_category = TE_Question_Category::all();
        $faculties = Faculty::all();
        // return $faculties;
        $this_course = Course::where('id',$id)->first();
        // return $this_course;
        return view('admin_student.teachers_evaluation.evaluation_form', compact('this_course','questions_category','faculties','session','student','session'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $check = TE_Main::where('student_id',$request->student_id)
                        ->where('semester_id',$request->semester_id)
                        ->where('course_id',$request->course_id)
                        ->where('faculty_id', $request->faculty_id)
                        ->count();
        if($check>0){
            toastr()->warning('Cannot evaluate same course for same teacher two times, select a new teacher!');
            return redirect()->back();
        }

        $request->validate([
            'student_id' => 'required',
            'semester_id' => 'required',
            'course_id' => 'required',
            'faculty_id' => 'required',
            'question_category.*' => 'required',
            'question_id.*' => 'required',
            'marks.*' => 'required'
        ]);
        // return $request;
        // storing the evaluation
        $this_evaluation = TE_Main::create([
            'student_id' => $request->student_id,
            'department' => $request->department,
            'semester_id' => $request->semester_id,
            'course_id' => $request->course_id,
            'faculty_id' => $request->faculty_id,
            'remarks' => $request->remarks,
        ]);
        // $this_evaluation = new TE_Main([
        //     'student_id' => $request->student_id,
        //     'semester_id' => $request->semester_id,
        //     'course_id' => $request->course_id,
        //     'faculty_id' => $request->faculty_id,
        // ]);
        // $this_evaluation->remarks = $request->remarks;
        // $this_evaluation->save();
        // receive this evaluation ID
        // $this_evaluation = TE_Main::latest()->first();
        // storing marks
        foreach ($request->question_id as $index => $qs) {
            $e_marks = new TE_Marks([
                'evaluation_id' => $this_evaluation->id,
                'qs_category_id' => $request->question_category[$index],
                'qs_id' => $qs,
                'scale' => $request->marks[$index],
            ]);
            $e_marks->save();
        }
        toastr()->success('Evaluation Completed', 'Success');
        return redirect()->route('student-teacher-evaluation.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

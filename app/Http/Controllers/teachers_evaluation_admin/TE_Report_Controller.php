<?php

namespace App\Http\Controllers\teachers_evaluation_admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Department;
use App\Current_Semester_Running;
use App\TE_Main;
use App\TE_Marks;
use App\Faculty;
use App\TE_Question;
use App\TE_Question_Category;
use DB;

class TE_Report_Controller extends Controller
{
    // listing all departments
    public function index(){
        $departments = Department::all();
        return view('admin_teacher_evaluation.report.index',compact('departments'));
    }
    // listing departments
    public function semester($department_id){
        $semesters = Current_Semester_Running::all();
        return view('admin_teacher_evaluation.report.semester',compact('semesters','department_id'));
    }
    // listing faculties with courses evaluated
    public function faculty_list($department_id,$semester_id){
        $faculties = Faculty::where('department_id',$department_id)
                            ->where('status','1')
                            ->get();
        // $evaluations = DB::table('t_e__mains')
        //                 ->join('faculties','t_e__mains.faculty_id','=','faculties.id')
        //                 ->join('current__semester__runnings','t_e__mains.semester_id','=','current__semester__runnings.id')
        //                 ->select('t_e__mains.*','faculties.name','current__semester__runnings.title')
        //                 ->get();
        //return $evaluations;
        return view('admin_teacher_evaluation.report.faculties',compact('faculties','semester_id'));
    }
    // generating reports
    public function report($semester_id, $faculty_id, $course_id){
        $total_evaluations = TE_Main::where('course_id',$course_id)
                                    ->where('faculty_id',$faculty_id)
                                    ->where('semester_id',$semester_id)
                                    ->count();
        //return $total_evaluations;
        $evaluation_ids = TE_Main::select('id')
                                ->where('course_id',$course_id)
                                ->where('faculty_id',$faculty_id)
                                ->where('semester_id',$semester_id)
                                ->get();
        $evaluation_ids = $evaluation_ids->pluck('id');
        //return $evaluation_ids;
        $total = 0;
        foreach($evaluation_ids as $ev_id){
            $marks = TE_Marks::where('evaluation_id',$ev_id)->sum('scale');
            $total = $total+$marks;
            $total_array[] = $marks;
        }
        //return $total_array;
        // return $total;

        $total_questions = TE_Question::all()->count();
        $highest_mark = $total_questions*5;
        //return $total_questions;
        $average_marks = $total/$total_evaluations;
        //return $total_marks;

        $percentage = round(($average_marks*100)/$highest_mark);
        // return $percentage
                                /** Calculating Category Wise Marks */
        $categories = TE_Question_Category::select('id','category_name')
                                          ->get();
        //return $categories;

        //$categories_total[]=0;
        $category_marks_total = 0;
        //return $categories_total;

        foreach($categories as $category){
            foreach($evaluation_ids  as $ev_id){
                $category_marks = TE_Marks::where('evaluation_id',$ev_id)
                                          ->where('qs_category_id',$category->id)
                                          ->sum('scale');
                $category_marks_total = $category_marks_total+$category_marks;
            }
            $categories_total[]=$category_marks_total;
            $category_marks_total = 0;
        }
        //return $categories_total;

                                /** Calculating Per Question wise marks */
        $questions = TE_Question::select('id','question_title')->get();
        //return $questions;
        $questions_marks_total = 0;

        foreach($questions as $question){
            foreach($evaluation_ids  as $ev_id){
                $question_marks = TE_Marks::where('evaluation_id',$ev_id)
                                          ->where('qs_id',$question->id)
                                          ->sum('scale');
                $questions_marks_total = $questions_marks_total+$question_marks;
            }
            $question_total[]=$questions_marks_total;
            $questions_marks_total = 0;
        }
        //return $question_total;

        return view('admin_teacher_evaluation.report.report',compact('total_evaluations','highest_mark','total','average_marks','percentage','faculty_id','course_id','categories','categories_total','questions','question_total','evaluation_ids'));
    }

    // not evaluated student list
    public function not_evaluated_index(){
        $semesters = \App\Current_Semester_Running::all();
        $departments = \App\Department::all();
        // return $semesters;
        return view('admin_teacher_evaluation.report.not_evaluated',compact('semesters','departments'));
    }
    // search students not evaluated
    public function not_evaluated_search(Request $request){
        
        try{
            // return $request;
            $students = DB::select("SELECT student_id from(Select student_id, department from registrations where department='$request->department' and reg_type in (1,2) and semester='$request->semester')as table1 where student_id not in (select distinct student_id from t_e__mains where semester_id='$request->semester'and department='$request->department') order by table1.student_id asc");
            return view('admin_teacher_evaluation.report.not_evaluated',compact('students','request'));
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
}

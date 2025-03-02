<?php

namespace App\Http\Controllers;

use App\Mark;
use App\Department;
use App\Helper\Helper;
use App\StudentInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Result;

class AcademicTranscriptController extends Controller
{
  public function report_card_index()
  {
    try {
      $students = StudentInfo::select('id', 'name','student_id')->orderBy('name', 'asc')->get();
      $classes = Department::all();
      return view('academic.report_card.index', compact('students', 'classes'));
    } catch (\Throwable $th) {
      return $th->getMessage();
    }
  }

  public function report_card_generate(Request $request)
  {
      try {
          $additional_data = [
            'un_absent' => $request->un_absent, // Unjustified Abs. (No of hrs.)
            'absent' => $request->absent, // Justified Abs (No of hrs.)
            'late' => $request->late, // Late (No of times)
            'punishment' => $request->punishment, // Punishment (No of hrs.)
            'warning' => $request->warning, // Conduct Warning
            'reprimand' => $request->reprimand, // Reprimand
            'suspension' => $request->suspension, // Suspension
            'remarks' => $request->remarks, // Remarks on student performance
            'class_master' => $request->class_master, // Remarks on student performance
          ];
          $student = StudentInfo::find($request->student_id);
          $class = Department::find($request->class_id);
          $semester = $request->semester;
          if ($semester != config('constant.annual')) {
            $marks = Mark::where('semester', $request->semester)->where('student_id', $request->student_id)->where('class_id', $request->class_id)->get();
            // return $marks;
            if($marks->count() == 0){
              toastr()->error('No grades were found in the system, please check if the grades are uploaded correctly.','Grades Missing!');
              return redirect()->back();
            }
            /**
             * Store Data of this semester in the result table
             */
            $total_coef = 0;
            $sum_n1_c=0;
            $sum_n2_c=0;
            $sum_avg_and_c=0;
            foreach ($marks as $item) {
                $sum_n1_c = $sum_n1_c + ($item->n1_mark * $item->course_id->coefficient);
                $sum_n2_c = $sum_n2_c + ($item->n2_mark * $item->course_id->coefficient);
                $sum_avg_and_c =$sum_avg_and_c+(($item->n1_mark+$item->n2_mark)/2)*$item->course_id->coefficient;
                $total_coef = $total_coef + $item->course_id->coefficient;
            }
            $part_1 = number_format($sum_n1_c / $total_coef, 2, '.', '');
            $part_2 = number_format($sum_n2_c / $total_coef, 2, '.', '');
            $total_marks =  $sum_avg_and_c;
            $term_average = number_format($sum_avg_and_c/$total_coef, 2, '.', '');
            Result::updateOrCreate(
              [
                'semester' => $semester,
                'student_id' => $request->student_id,
                'class_id' => $request->class_id,
                'year' => $marks->first()->academic_year,
              ],
              [
                'part_1' => $part_1,
                'part_2' => $part_2,
                'total_marks' => $total_marks,
                'total_coef' => $total_coef,
                'term_average' => $term_average
              ]
            );
            $results = Result::where('student_id', $request->student_id)->where('class_id', $request->class_id)->where('semester',$semester)->first();
            $all_results = Result::where('year', $marks->first()->academic_year)->where('class_id', $request->class_id)->where('semester',$semester)->orderBy('term_average','desc')->get();
            foreach ($all_results as $index => $item) {
              if($item->student_id == $request->student_id){
                $position = $index+1;
              }
            }
            // return $results;
            return view('academic.report_card.report_card', compact('additional_data','marks', 'class', 'student', 'semester', 'results','position'));
          }else{
            $courses = Helper::get_listof_subjects($student->id, $class->id)->pluck('course_id')->toArray();
            $annual_grades = [];
            foreach ($courses as $course_id) {
              $marks = Mark::whereIn('semester',[config('constant.sem1'), config('constant.sem2'), config('constant.sem3')])->where('student_id', $student->id)->where('class_id',$class->id)->where('course_id',$course_id)->latest()->get();
              if($marks->count() > 0){
                foreach($marks as $semester_marks){
                  if($semester_marks->semester == config('constant.sem1')){
                    $sem1_average = ($semester_marks->n1_mark + $semester_marks->n2_mark)/2;
                  }elseif($semester_marks->semester == config('constant.sem2')){
                    $sem2_average = ($semester_marks->n1_mark + $semester_marks->n2_mark)/2;
                  }else{
                    $sem3_average = ($semester_marks->n1_mark + $semester_marks->n2_mark)/2;
                  }
                }
                $total_average = number_format(($sem1_average+$sem2_average+$sem3_average)/3, 2);
                $course_grade = [
                  'academic_year' => $marks->first()->academic_year,
                  'course' => $marks->first()->course_id->name,
                  'first_sem' => $sem1_average,
                  'second_sem' => $sem2_average,
                  'third_sem' => $sem3_average,
                  'average' => $total_average,
                  'coef' => $marks->first()->course_id->coefficient,
                  'av_coef' => number_format(($total_average * $marks->first()->course_id->coefficient),2),
                  'remark' => Helper::calculate_average_grade($total_average)[0],
                  'signature' => $marks->where('semester', config('constant.sem3'))->first()->signature,
                ];
                array_push($annual_grades,$course_grade);
              }
            }
            // return $annual_grades;
            return view('academic.report_card.report_card', compact('additional_data','class', 'student', 'semester', 'annual_grades'));
          }
        } catch (\Throwable $th) {
          return $th->getMessage();
    }
  }
}

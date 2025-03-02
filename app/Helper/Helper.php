<?php

namespace App\Helper;

use Throwable;
use App\AcademicYear;
use App\OutlineCourse;
use App\PromoteStudent;
use App\StudentInfo;

class Helper
{
  public static function calculate_grade_letter($percentage)
  {
    try {
      if ($percentage > 89) {
        return ["A+",'CVWA'];
      } elseif ($percentage > 79) {
        return ["A",'CVWA'];
      } elseif ($percentage > 74) {
        return ["B+",'CWA'];
      } elseif ($percentage > 69) {
        return ["B",'CWA'];
      } elseif ($percentage > 59) {
        return ["C+",'CA'];
      } elseif ($percentage > 49) {
        return ["C",'CAA'];
      } else {
        return ["D",'CNA'];
      }
    } catch (Throwable $th) {
      return $th->getMessage();
    }
  } 
  // this function is additionally written because we are sending the average here to calculate the letter grade. Because the average total marks we calculated is the average of marks*coeffcient. That average does not give you the actual figure.
  public static function calculate_average_grade($average)
  {
    try {
      if ($average >= 18.00 && $average <= 20.00) {
          return ["A+", 'CVWA'];
      } elseif ($average >= 16.00 && $average < 18.00) {
          return ["A", 'CVWA'];
      } elseif ($average >= 15.00 && $average < 16.00) {
          return ["B+", 'CWA'];
      } elseif ($average >= 14.00 && $average < 15.00) {
          return ["B", 'CWA'];
      } elseif ($average >= 12.00 && $average < 14.00) {
          return ["C+", 'CA'];
      } elseif ($average >= 10.00 && $average < 12.00) {
          return ["C", 'CAA'];
      } else {
          return ["D", 'CNA'];
      }
    } catch (Throwable $th) {
      return $th->getMessage();
    }
  }

  public static function getActiveAcademicYear(){
      try {
          return AcademicYear::where('status','active')->first();
      } catch (Throwable $th) {
          return $th->getMessage();
      }
  }

  public static function generateStudentUniqueID():string
  {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $uniqueCode = '';

    for ($i = 0; $i < 6; $i++) {
        $uniqueCode .= $characters[rand(0, $charactersLength - 1)];
    }
    $checkValue = StudentInfo::where('student_id', $uniqueCode)->exists();
    if($checkValue){
        self::generateStudentUniqueID();
    }
    return strtoupper($uniqueCode);
  }

  public static function reforgeStudentId($student){
    $dynamic_part = substr(\Carbon::parse($student->getOriginal('admission_date'))->year,-2);
    return config('constant.id_heading').$dynamic_part.str_pad($student->id, 3, '0', STR_PAD_LEFT);
  }

  public static function getYear($date_string){
     return \Carbon::parse($date_string)->year;
  }
  public static function get_listof_subjects($student, $class){
    $academic_year = PromoteStudent::where('student_id',$student)->where('department_id',$class)->first()->academic_year;
    $outline = PromoteStudent::where('academic_year',$academic_year)->where('student_id',$student)->where('department_id',$class)->first()->outline_id;
    $syllabus = OutlineCourse::with('course')->where('outline_id',$outline)->get();
    return $syllabus;
  }

  public static function ordinal($position) {
    $ends = ['th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'];
    if (($position % 100) >= 11 && ($position % 100) <= 13) {
        return $position . 'th';
    }
    return $position . $ends[$position % 10];
  }
}

<?php
namespace App\traits;
use App\Mark;
use App\PromoteStudent;
use App\Receivable;
use Throwable;

trait StudentInformation{
    private function checkStudentGradeBook($promoteStudent){
        try {
            $grade= Mark::where('academic_year',$promoteStudent->academic_year)->where('student_id',$promoteStudent->student_id)->exists();
            if ($grade){
                return true;
            }
            return false;
        }catch (Throwable $throwable){
            return $throwable->getMessage();
        }
    }

    public function checkStudentPayment($promoteStudent){
        try {
            $payment= Receivable::whereYear('updated_at',$promoteStudent->academic_year)->exists();
            if ($payment){
                return true;
            }
            return false;
        }catch (Throwable $throwable){
            return $throwable->getMessage();
        }
    }
}
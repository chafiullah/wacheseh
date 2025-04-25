<?php

namespace App\Imports;

use App\Helper\Helper;
use App\Mark;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class AdditionalData implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    public function model(array $row)
    {
        $average = ($row['n1_mark'] + $row['n2_mark']) / 2;
        $percentage = ($average * 100) / 20;
        $letter_grade = Helper::calculate_grade_letter($percentage);
        return Mark::updateOrCreate(
            [
                'academic_year' => $row['academic_year'],
                'semester' => $row['semester'],
                'class_id' => $row['class_database_id'],
                'student_id' => $row['student_database_id'],
                'course_id' => $row['course_database_id']
            ],
            [
                'n1_mark' => $row['n1_mark'],
                'n2_mark' => $row['n2_mark'],
                'grade' => $letter_grade[0],
                'remark' => $letter_grade[1],
                'signature' => strtoupper($row['signature']),
            ]
        );
    }
}

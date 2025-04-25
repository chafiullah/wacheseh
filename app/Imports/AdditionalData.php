<?php

namespace App\Imports;

use App\ResultCompliment;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class AdditionalData implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    public function model(array $row)
    {
        return ResultCompliment::updateOrCreate([
            'student_id' => $row['student_id'],
            'class_id' => $row['class_id'],
            'semester' => $row['semester'],
        ],[
            'un_absent' => $row['un_absent'],
            'late' => $row['late'],
            'warning'=>$row['warning'],
            'reprimand'=>$row['reprimand'],
            'suspension'=>$row['suspension'],
            'class_master'=>$row['class_master'],
            'remarks'=>$row['remarks'],
        ]);
    }
}

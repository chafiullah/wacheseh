<?php

namespace App\Imports;

use App\StudentExam;
use Maatwebsite\Excel\Concerns\ToModel;

class StudentExamImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new StudentExam([
            'examID' => $row[0],
            'studentID' => $row[1],
            'date' => $row[2],
            'status' => $row[3]
        ]);
    }
}

<?php

namespace App\Imports;

use App\Registration;
use Maatwebsite\Excel\Concerns\ToModel;

class EnrollStudentCourse implements ToModel
{
    /**
    * @param array $row
    */
    public function model(array $row)
    {
        return new Registration([
            'courseID' => $row[0],
            'studentID' => $row[1],
            'starts' => $row[3],
            'ends' => $row[4]
         ]);
    }
}

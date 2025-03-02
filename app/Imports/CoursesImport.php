<?php

namespace App\Imports;

use App\Course;
use Maatwebsite\Excel\Concerns\ToModel;

class CoursesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Course([
            'course_code' => $row[0],
            'course_name' => $row[1],
            'credit' => $row[2],
            'tableLocation' => $row[3],
            'table_order' => $row[4]
        ]);
    }
}

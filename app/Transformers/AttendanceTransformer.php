<?php

namespace App\Transformers;


use League\Fractal\TransformerAbstract;
use App\Attendance;

class AttendanceTransformer extends TransformerAbstract
{
  /**
  * @param \App\Attendance $attendance
  *
  * @return array
  */
  public function transform(Attendance $attendance)
  {

    return [
      'id' => (int)$attendance->id,
      'students' => $attendance->students_id,
      'name' => $attendance->student()->Full_Name,
      'present' => $attendance->present,
    ];
  }
}

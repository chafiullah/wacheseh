<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CourseGroupStudent extends Model implements Auditable
{
 use \OwenIt\Auditing\Auditable;
 protected $table = 'courses_groups_students';
 protected $guarded = ['id'];

 public function student()
 {
  return $this->belongsTo(StudentInfo::class, 'student_id', 'id');
 }
}

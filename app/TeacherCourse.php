<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class TeacherCourse extends Model implements Auditable
{
 use \OwenIt\Auditing\Auditable;

 protected $table = 'teacher_course_profiles';
 protected $guarded = ['id'];

 public function course_profile()
 {
  return $this->belongsTo(CourseProfile::class, 'profile_id', 'id');
 }
}

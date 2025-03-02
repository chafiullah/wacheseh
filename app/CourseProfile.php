<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CourseProfile extends Model implements Auditable
{
 use \OwenIt\Auditing\Auditable;

 protected $table = 'course_profiles';
 protected $guarded = ['id'];

 public function course_profile_courses()
 {
  return $this->hasMany(CourseProfileCourse::class, 'profile_id', 'id');
 }
}

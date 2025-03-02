<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CourseGroup extends Model implements Auditable
{

 // use SoftDeletes;
 use \OwenIt\Auditing\Auditable;

 protected $table = 'courses_groups';
 protected $guarded = ['id'];

 public function group_students()
 {
  return $this->hasMany(CourseGroupStudent::class, 'group_id', 'id');
 }
}

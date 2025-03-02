<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Course extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'courses';
    protected $guarded = ['id'];
    protected $hidden = ['created_at', 'updated_at'];

    public function course_groups()
    {
        return $this->hasMany(CourseGroup::class, 'course_id', 'id');
    }
}

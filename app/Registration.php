<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Registration extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'class_courses';
    protected $guarded = ['id'];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function class()
    {
        return $this->belongsTo(Department::class, 'class_id', 'id');
    }
}

<?php

namespace App;

use App\StudentInfo;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Mark extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'marks';
    protected $guarded = ['id'];

    public function getSemesterIdAttribute($value)
    {
        if ($value == 1) {
            return config('constant.sem1');
        } elseif ($value == 2) {
            return config('constant.sem2');
        } else {
            return config('constant.sem3');
        }
    }

    public function getClassIdAttribute($value)
    {
        return Department::find($value)->name;
    }

    public function getCourseIdAttribute($value)
    {
        return Course::find($value);
    }

    public function student()
    {
        return $this->belongsTo(StudentInfo::class, 'student_id', 'id');
    }
}

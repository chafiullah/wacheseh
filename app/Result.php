<?php

namespace App;

use App\StudentInfo;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Result extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'results';
    protected $guarded = ['id'];

    public function student()
    {
        return $this->belongsTo(StudentInfo::class, 'student_id', 'id');
    }

     public function class()
    {
        return $this->belongsTo(Department::class, 'class_id', 'id');
    }
}

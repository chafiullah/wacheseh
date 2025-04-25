<?php


namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ResultCompliment extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'result_compliments';
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

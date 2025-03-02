<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Course_Student extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'courses_student';
    protected $fillable = ['semester', 'levelTerm','student_id','course_id','reg_type','course_status','department'];

    public function course()
    {
        return $this->belongsTo('App\Course','course_id');
    }
}

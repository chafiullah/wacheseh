<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PromoteStudent extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'student_departments';
    protected $guarded = ['id'];

    public function student(){
        return $this->belongsTo(StudentInfo::class,'student_id','id');
    }
    public function department(){
        return $this->belongsTo(Department::class,'department_id','id');
    }
    public function outline(){
        return $this->belongsTo(Outline::class,'outline_id','id'); 
    }
}

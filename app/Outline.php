<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Outline extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'outlines';
    protected $guarded = ['id'];

    public function department(){
        return $this->belongsTo(Department::class,'class_id','id');
    }
    public function outlinecourses(){
        return $this->hasMany(OutlineCourse::class);
    }
}

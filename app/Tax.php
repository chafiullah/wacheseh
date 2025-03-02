<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Tax extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'studenttaxes';
    protected $fillable = ['studentID','amount'];

    public function student(){
        return $this->belongsTo(StudentInfo::class,'studentID','studentID');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ProgramOutline extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'program_outlines';
    protected $guarded = ['id'];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class StudentExam extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable; 
    protected $table = 'general_instructions';
    protected $guarded = ['id'];
}

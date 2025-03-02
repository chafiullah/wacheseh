<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class AcademicYear extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'academic_years';
    protected $guarded = ['id'];
}

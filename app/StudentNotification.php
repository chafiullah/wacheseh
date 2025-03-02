<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class StudentNotification extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'studentnotifications';
    protected $fillable = ['studentID','subject','notification','sentBy','status'];
}

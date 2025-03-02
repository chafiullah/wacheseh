<?php

namespace App;

use App\User;
use App\StudentInfo;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Receivable extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'payment_history';
    protected $guarded = ['id'];

    public function paymentTitle()
    {
        return $this->belongsTo(Fee::class, 'paidFor', 'id');
    }

    public function student()
    {
        return $this->hasOne(StudentInfo::class, 'id', 'studentID');
    }
}

<?php

namespace App;

use App\StudentInfo;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Message extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'messages';
    protected $guarded = ['id'];
}

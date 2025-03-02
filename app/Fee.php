<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Fee extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'fees';
    protected $guarded = ['id'];
}

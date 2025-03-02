<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class OutlineYear extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'outline_years';
    protected $guarded = ['id'];
}

<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Document extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'documents';
    protected $guarded = ['id'];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('m/d/y');
    }
}

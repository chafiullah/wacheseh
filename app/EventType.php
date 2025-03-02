<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class EventType extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'event_types';
    protected $fillable = ['title','status'];
}

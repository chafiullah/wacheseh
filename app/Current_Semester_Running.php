<?php

namespace App;

use \Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Current_Semester_Running extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    const ACTIVE = 'active';
    protected $table = 'current__semester__runnings';
    protected $guarded = ['id'];

 
    public function events()
    {
        return $this->hasMany(Event::class, 'session_id', 'id');
    }

    public function getFromAttribute($value){
        return Carbon::parse($value)->format('m/d/Y');
    }
    public function getToAttribute($value){
        return Carbon::parse($value)->format('m/d/Y');
    }
}
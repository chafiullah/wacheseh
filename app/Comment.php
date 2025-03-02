<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Comment extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'student_comments';
    protected $guarded = ['id'];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id', 'id');
    }
    
}

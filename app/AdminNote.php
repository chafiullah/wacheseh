<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class AdminNote extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'admin_notes';
    protected $fillable = ['sender', 'receiver', 'note', 'status', 'subject'];
    public function user()
    {
        return $this->belongsTo(User::class, 'sender', 'id');
    }
}

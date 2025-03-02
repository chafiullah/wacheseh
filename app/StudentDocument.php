<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class StudentDocument extends Model implements Auditable
{
 use \OwenIt\Auditing\Auditable;
 protected $table = 'student_documents';
 protected $guarded = ['id'];

 public function doc_count()
 {
  return $this->hasMany(StudentDocument::class, 'student_id', 'student_id');
 }

 public function student()
 {
  return $this->belongsTo(StudentInfo::class, 'student_id', 'studentID');
 }
}

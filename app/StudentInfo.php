<?php

namespace App;

use App\Helper\Helper;
use Carbon\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class StudentInfo extends Authenticatable implements Auditable
{
  use \OwenIt\Auditing\Auditable;

  protected $table = "student_infos";
  protected $guarded = ["id"];
  protected $hidden = ['password'];

  public function getRegionAttribute($value)
  {
    try {
      return Region::find($value)->name;
    } catch (\Throwable $th) {
      return $th->getMessage();
    }
  }

  public function getClassAttribute($value)
  {
    try {
      $archive=PromoteStudent::with('department')->where('academic_year',Helper::getActiveAcademicYear()->academic_year)->where('student_id',$this->id)->first();
      return $archive->department->name;
    } catch (\Throwable $th) {
      return $th->getMessage();
    }
  }

  public function getAdmissionDateAttribute($value)
  {
    try {
      return Carbon::parse($value)->format('d M Y');
    } catch (\Throwable $th) {
      return $th->getMessage();
    }
  }

  public function getDateOfBirthAttribute($value)
  {
    try {
      return Carbon::parse($value)->format('d M Y');
    } catch (\Throwable $th) {
      return $th->getMessage();
    }
  }
}

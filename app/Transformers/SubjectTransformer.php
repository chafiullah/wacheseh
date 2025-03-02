<?php

namespace App\Transformers;


use League\Fractal\TransformerAbstract;
use App\Subject;
use DB;

class SubjectTransformer extends TransformerAbstract
{
  
  /**
  * @param \App\Subject $subjects
  *
  * @return array
  */
  public function transform(Subject $subjects)
  {
   // $subjects = DB::table('subjects')->get();
    return [

      'id' => (int)$subjects->id,
      'code' => $subjects->code,
      'name' => $subjects->name,
    ];
  }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\StudentInfoImport;
use App\Region;
use Maatwebsite\Excel\Facades\Excel;

class ImportStudentController extends Controller
{

  public function import_std()
  {
    try {
      $regions = Region::all();
      return view('student.import', compact('regions'));
    } catch (\Throwable $th) {
      return $th->getMessage();
    }
  }


  public function import_st(Request $request)
  {
    // return $request;
    try {
      Excel::import(new StudentInfoImport, $request->file);
      toastr()->success('Success', 'Import successful');
      return redirect()->back();
    } catch (\Throwable $th) {
      return $th->getMessage();
    }
  }

  public function import_st_update(Request $request)
  {
    return $request;
  }
}

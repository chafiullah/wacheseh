<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\UserImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportUserController extends Controller
{
  public function import(Request $request) {
    try {
        // Make sure the uploaded file exists
        if ($request->hasFile('file')) {
            // Import the file
            Excel::import(new UserImport, $request->file('file'));
            toastr()->success('Success', 'Import successful');
        } else {
            toastr()->error('Error', 'File not found');
        }
        
        return redirect()->back();
    } catch (\Throwable $th) {
        return $th->getMessage();
    }
  }
}

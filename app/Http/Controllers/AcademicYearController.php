<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AcademicYear;
use Throwable;

class AcademicYearController extends controller{
    public function listAcademicYear(){
        try {
            $academic_years = AcademicYear::orderBy('status')->get();
            return view('academic_year.index', compact('academic_years'));
        }catch (Throwable $throwable){
            return $throwable->getMessage();
        }
    }

    public function storeAcademicYear(Request $request){
        try {
            AcademicYear::updateOrCreate(
                ['academic_year'=>$request->input('academic_year')],
                [
                    'alias'=>$request->input('alias'),
                    'status'=>'inactive'
                ]
            );
            toastr()->success('Academic year has been added to the system.','Success');
            return redirect()->back();
        }catch (Throwable $throwable){
            return $throwable->getMessage();
        }
    }

    public function activeAcademicYear($id){
        try {
            $academic_year = AcademicYear::find($id);
            $active_academic_year=Helper::getActiveAcademicYear()->academic_year;
            if($active_academic_year != $academic_year->academic_year){
                AcademicYear::where('academic_year',$active_academic_year)->update([
                    'status'=>'inactive'
                ]);
            }
            $academic_year->update([
                'status'=>'active'
            ]);
            toastr()->success('Academic year has been activated for whole the system.','Success');
            return redirect()->back();
        }catch (Throwable $throwable){
            return $throwable->getMessage();
        }
    }

    public function destroyAcademicYear($id){
        try {
            $academic_year = AcademicYear::find($id);
            if($academic_year->status == 'active'){
                toastr()->success('This academic year is currently active in the system which means it cannot be deleted.','Success');
                return redirect()->back();
            }
            $academic_year->delete();
            toastr()->success('Academic year has been removed from the system.','Success');
            return redirect()->back();
        }catch (Throwable $throwable){
            return $throwable->getMessage();
        }
    }
}
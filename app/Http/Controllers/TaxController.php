<?php

namespace App\Http\Controllers;

use App\Receivable;
use App\Tax;
use App\StudentInfo;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;

class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $oldPayments = Tax::all();
        $students = StudentInfo::where('academicStatus','!=','Withdrawn')->get();
        return view('accounting.1098.index', compact('oldPayments','students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($studentID)
    {
        $student = StudentInfo::where('studentID',$studentID)->first();
        $oldPayment = Tax::where('studentID',$student->studentID)->sum('amount');
        // return $oldPayment;

        $newNovember = Receivable::where('studentID',$student->studentID)->where('responseCode','1')->whereMonth('created_at',date('m',strtotime("2021-11-30")))->sum('amount');

        $newDecember = Receivable::where('studentID',$student->studentID)->where('responseCode','1')->whereMonth('created_at',date('m',strtotime("2021-12-31")))->sum('amount');
       
        $newPayment = $newNovember+$newDecember;
        
        $totalPaid = $oldPayment+$newPayment;
        $details = array(
            "name" => $student->firstName.' '.$student->lastName,
            "ssn" => $student->ssn,
            "street" => $student->address,
            "address" => $student->city.', '.$student->state.', USA, '.$student->zip,
            "amount" => $totalPaid
        );
        // return $oldPayment.'-'.$newNovember.'-'.$newDecember;
        $pdf = PDF::loadView('accounting.1098.1098',['details' => $details]);
        return $pdf->download($details['name'].' - 1098.pdf');
        // return view('accounting.1098.1098',compact('student'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'studentID' => 'required|unique:studentTaxes,studentID'
        ]);
        try {
            Tax::create($request->all());
            toastr()->success('Payment added successfully','Success');
            return redirect()->back();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function show(Tax $tax)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $old = Tax::find($id);
            return view('accounting.1098.edit', compact('old'));
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            Tax::find($id)->update($request->all());
            toastr()->success('Payment updated successfully','Success');
            return redirect()->route('tax.old.index');
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Tax::destroy($id);
            toastr()->success('Payment deleted successfully','Success');
            return redirect()->back();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}

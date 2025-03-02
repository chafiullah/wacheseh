<?php

namespace App\Http\Controllers\Accounting;

use App\Fee;
use App\Mark;
use Carbon\Carbon;
use Stripe\Charge;
use Stripe\Stripe;
use App\Receivable;
use App\StudentInfo;
use App\Helper\Helper;
use Illuminate\Http\Request;
use Psy\Command\HelpCommand;
use App\Mail\PaymentConfirmation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

class FeeController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $fees = Fee::orderBy("payableAmount", "asc")->get();
    return view("accounting.fee.index", compact("fees"));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    Fee::create($request->all());
    toastr()->success("Fee added successfully", "Success");
    return redirect()->back();
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $fee = Fee::find($id);
    return view("accounting.fee.edit", compact("fee"));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    Fee::where("id", $id)->update($request->except("_token", "_method"));
    toastr()->success("Fee updated successfully", "Success");
    return redirect()->route("fee.index");
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    // return $id;
    $fee = Fee::find($id);
    $fee->delete();
    toastr()->success("Fee deleted successfully", "Success");
    return redirect()->route("fee.index");
  }


  public function manualPaymentIndex()
  {
    try {
      $students = StudentInfo::all();
      $feeTypes = Fee::orderBy("payableAmount", "asc")->get();
      return view(
        "accounting.receivable.manualPayment",
        compact("students", "feeTypes")
      );
    } catch (\Throwable $th) {
      return $th->getMessage();
    }
  }

  public function manualPaymentStore(Request $request)
  {
    try {
      if ($request->paymentMethod != "card") {
        /** setting up the details for email */
        Receivable::create([
          "studentID" => $request->studentID,
          "paidFor" => $request->paidFor,
          "amount" => $request->amount,
          "responseCode" => 1,
          "actionBy" => auth()->user()->name,
          'paid_by' => $request->paymentMethod,
          'note' => $request->note
        ]);
        toastr()->success("Payment successful!", "Success");
        return redirect()->back();
      } else {
        Stripe::setApiKey(config('constant.stripe_secret'));
        $transaction = Charge::create([
          "amount" => $request->amount * 100,
          "currency" => "usd",
          "source" => $request->stripeToken,
          "description" => 'Paid For: ' . $request->paidFor
        ]);
        if ($transaction->status == 'succeeded') {
          Receivable::create([
            "studentID" => $request->studentID,
            "paidFor" => $request->paidFor,
            'paid_by' => 'card',
            "amount" => $request->amount,
            "responseCode" => 1,
            "actionBy" => auth()->user()->name,
            'note' => $request->note
          ]);
          toastr()->success('Transaction Successful', 'Success');
        } else if ($transaction->status == 'processing') {
          Receivable::create([
            "studentID" => $request->studentID,
            "paidFor" => $request->paidFor,
            'paid_by' => 'card',
            "amount" => $request->amount,
            "responseCode" => 1,
            "actionBy" => auth()->user()->name,
            'note' => $request->note
          ]);
          toastr()->warning('Transaction under process', 'Processing');
        } else {
          toastr()->error('Transaction Delined', 'Error');
          return redirect()->back();
        }
      }
      return redirect()->back();
    } catch (\Throwable $th) {
      return $th->getMessage();
    }
  }

  public function manualPaymentEdit($id)
  {
    try {
      $payment = Receivable::find($id);
      $students = StudentInfo::all();
      $feeTypes = Fee::orderBy("payableAmount", "asc")->get();
      return view(
        "accounting.receivable.manualEdit",
        compact("payment", "students", "feeTypes")
      );
    } catch (\Throwable $th) {
      return $th->getMessage();
    }
  }

  public function manualPaymentDestroy($id)
  {
    try {
      Receivable::destroy($id);
      toastr()->success("Record deleted!", "Success");
      return redirect()->route("fee.manual.index");
    } catch (\Throwable $th) {
      return $th->getMessage();
    }
  }

  public function manualPaymentUpdate(Request $request, $id)
  {
    try {
      Receivable::where("id", $id)->update([
        "studentID" => $request->studentID,
        "paidFor" => $request->paidFor,
        'paid_by' => $request->paymentMethod,
        "amount" => $request->amount,
        "responseCode" => 1,
        "actionBy" => auth()->user()->name,
        'note' => $request->note
      ]);
      toastr()->success("Record updated!", "Success");
      return redirect()->route("fee.manual.index");
    } catch (\Throwable $th) {
      return $th->getMessage();
    }
  }

  public function paymentApprove($id)
  {
    $payment = Receivable::with("paymentTitle")->find($id);
    $student = StudentInfo::where("studentID", $payment->studentID)->first();
    Receivable::where("id", $id)->update([
      "responseCode" => "1",
    ]);
    $details = [
      "trxID" => $payment->trxID,
      "paymentType" => $payment->paymentTitle->feeTitle,
      "amount" => $payment->amount,
      "studentID" => $student->studentID,
      "firstName" => $student->firstName,
      "lastName" => $student->lastName,
    ];

    Mail::to($student->email)->send(new PaymentConfirmation($details));
    toastr()->success("Payment approved!", "Success");
    return redirect()->route("fee.payment.today");
  }

  public function paymentReject($id)
  {
    Receivable::where("id", $id)->update([
      "responseCode" => "2",
      "messageCode" => "254",
    ]);
    toastr()->error("Payment Rejected!", "Rejected");
    return redirect()->route("fee.payment.today");
  }
  /*
   * Payment History
   * */
    public function paymentToday()
    {
        try {
            $payments = Receivable::with(
                "paymentTitle",
                "student:id,student_id,first_name,last_name,email,phone"
            )
                ->whereDate("created_at", Carbon::today())
                ->orderBy("amount", "asc")
                ->get();
//             return $payments;
            return view("accounting.receivable.index", compact("payments"));
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
  public function paymentDateWise(Request $request)
  {
    try {
        $start_date = $request->input('startDate');
        $end_date = $request->input('endDate');
        if ($request->input('type') === 'paid'){
            $payments = Receivable::with(
                "paymentTitle",
                "student:id,student_id,first_name,last_name,email,phone"
            )
                ->whereBetween("created_at", [$start_date, $end_date])
                ->latest()
                ->get();
            // return $payments;
            $unpaidList=null;
        }else{
            $unpaidList = [];
            $students = StudentInfo::where('status',config('constant.active'))->get();
            foreach ($students as $student) {
                $check = Receivable::where("studentID", $student->id)
                    ->whereBetween("created_at", [$start_date, $end_date])
                    ->exists();
                if (!$check) {
                    array_push($unpaidList, $student->id);
                }
            }
            $payments = null;
        }
      return view("accounting.receivable.report", compact("payments", 'unpaidList','start_date', 'end_date'));
    } catch (\Throwable $th) {
      return $th->getMessage();
    }
  }
  /**
   * Reporting methods
   */

  public function withdrawn_refund()
  {
    try {
      $students = StudentInfo::select("studentID", "firstName", "lastName")
        ->where("academicStatus", "!=", "Graduate")
        ->get();
      return view("refund.index", compact("students"));
    } catch (\Throwable $th) {
      return $th->getMessage();
    }
  }
  public function withdrawn_refund_generate(Request $request)
  {
    try {
      $student = StudentInfo::where("studentID", $request->student_id)->first();
      $total_paid = Helper::totalPaid(
        $student->studentID,
        $student->totalTution
      );
      $credits_completed = Helper::studentResult($student->studentID);
      $refund_amount = $total_paid["totalPaid"] - 292 * $credits_completed;
      return view(
        "refund.generate",
        compact("student", "total_paid", "credits_completed", "refund_amount")
      );
    } catch (\Throwable $th) {
      return $th->getMessage();
    }
  }

  /**
   * Ajax methods
   */
  public function minimumPayabale(Request $request)
  {
    $amount = Fee::where("id", $request->itemID)->first();
    return response()->json($amount->payableAmount);
  }
}

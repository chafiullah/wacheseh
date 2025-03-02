<?php

namespace App\Http\Controllers\student;

use App\Fee;
use Carbon\Carbon;
use Stripe\Charge;
use Stripe\Stripe;
use App\Receivable;
use App\StudentInfo;
use Illuminate\Http\Request;
use App\Mail\PaymentConfirmation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;


class PaymentController extends Controller
{
    public function index()
    {
        try {
            $student = auth()->user();
            $totalPaid = Receivable::where('studentID', $student->studentID)->where('paidFor', 1)->sum('amount');
            $totalBalance = $student->totalTution - $totalPaid;

            $feeTypes = Fee::orderBy('payableAmount', 'asc')->get();
            $dueMonths = [];
            if ($totalBalance > 0) {
                for ($i = 1; $i <= 1; $i++) {
                    $checkDate = Carbon::now()->subMonth($i);
                    // return $checkDate;
                    $checkMonth = date('m', strtotime($checkDate));
                    // dd($checkMonth);
                    $check = Receivable::where('studentID', $student->id)->whereMonth('advancePayment', $checkMonth)->exists();
                    // dd($check);
                    if (!$check) {
                        array_push($dueMonths, $checkDate);
                    }
                }
            }
            // return $dueMonths;
            return view('admin_student.payment.index', compact('student', 'feeTypes', 'dueMonths'));
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function makePyament(Request $request)
    {
        try {
            Stripe::setApiKey(config('constant.stripe_secret'));
            $transaction = Charge::create([
                "amount" => $request->amount * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => 'Paid For: ' . $request->paidFor
            ]);
            if ($transaction->status == 'succeeded') {
                Receivable::create([
                    "studentID" => auth()->user()->id,
                    "paidFor" => $request->paidFor,
                    'paid_by' => 'card',
                    "amount" => $request->amount,
                    "responseCode" => 1,
                    "actionBy" => auth()->user()->first_name,
                ]);
                toastr()->success('Transaction Successful', 'Success');
            } else if ($transaction->status == 'processing') {
                Receivable::create([
                    "studentID" => auth()->user()->id,
                    "paidFor" => $request->paidFor,
                    'paid_by' => 'card',
                    "amount" => $request->amount,
                    "responseCode" => 1,
                    "actionBy" => auth()->user()->first_name,
                ]);
                toastr()->warning('Transaction under process', 'Processing');
            } else {
                toastr()->error('Transaction Delined', 'Error');
            }
            return redirect()->back();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function paymentHistory()
    {
        try {
            $student = StudentInfo::find(auth()->user()->id);
            $payments = Receivable::with('paymentTitle')->where('studentID',  $student->id)->latest()->get();
            return view('admin_student.payment.payment_history', compact('payments','student'));
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}

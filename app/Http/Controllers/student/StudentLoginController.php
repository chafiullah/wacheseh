<?php

namespace App\Http\Controllers\student;

use App\StudentInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\PasswordResetMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class StudentLoginController extends Controller
{
    public function login(Request $request)
    {
        try {
            // return $request;
            $student = StudentInfo::where('student_id', $request->student_id)->first();
            if ($student) {
                $password_check = Hash::check($request->password, $student->password);
                if ($password_check) {
                    Auth::guard('student')->loginUsingId($student->id);
                    if (auth('student')->user()->status != config('constant.active')) {
                        Auth::guard("student")->logout();
                        toastr()->error('Access Denied', 'Denied');
                        return redirect()->route('base');
                    }
                    return redirect()->route('student.home');
                } else {
                    toastr()->error('Invalid Password!', 'Try again.');
                    return redirect()->back();
                }
            } else {
                toastr()->error('Student not found!', 'Invalid ID');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function logout()
    {
        try {
            Auth::guard("student")->logout();
            toastr()->success('Logged out successfully', 'Success');
            return redirect()->route('base');
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}

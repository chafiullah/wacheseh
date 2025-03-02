<?php

namespace App\Http\Controllers;

use App\User;
use App\StudentInfo;
use Illuminate\Http\Request;
use App\Mail\PasswordResetMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{
 public function send_otp(Request $request)
 {
  try {
   // return $request;
   if ($request->user_type == 'admin') {
    $user = User::select('id', 'email')->where('email', $request->email)->first();
   } else {
    $user = StudentInfo::select('id', 'email')->where('email', $request->email)->first();
   }
   // return $user;

   if (count($user) > 0) {
    $link = route('password.reset.link', [$request->user_type, encrypt($user->id)]);
    // return $link;
    Mail::to($user->email)->send(new PasswordResetMail($link));
    toastr()->success('Password reset link sent to this mail!', 'Success');
    return redirect()->back();
   } else {
    toastr()->error('Invalid User!', 'Unknown');
    return redirect()->back();
   }
  } catch (\Throwable $th) {
   return $th->getMessage();
  }
 }

 public function passwordUpdate($user, $user_id, Request $request)
 {
  try {

   if ($request->password != $request->password_confirm) {
    toastr()->error('Password did not match!', 'Error');
    return redirect()->back();
   } else {
    if ($request->user == 'admin') {
     $user = User::find($user_id);
     $user->update([
      'password' => Hash::make($request->password)
     ]);
     toastr()->success('Password updated successfully!', 'Success');
     return redirect()->route('login');
    } else {
     $user = StudentInfo::find($user_id);
     $user->update([
      'password' => Hash::make($request->password)
     ]);
     toastr()->success('Password updated successfully!', 'Success');
     return redirect()->route('base');
    }
   }
  } catch (\Throwable $th) {
   return $th->getMessage();
  }
 }
}

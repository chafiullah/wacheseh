<?php

namespace App\Http\Controllers\student;

use DB;
use App\StudentInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class StudentSettingController extends Controller
{
    public function index()
    {
        try {
            $student = auth()->user();
            return view('admin_student.profile.setting', compact('student'));
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function profile_update(Request $request)
    {
        try {
            // return $request;
            // return auth()->user();
            if ($request->task_for == 'information_change') {
                $password = Hash::check($request->password_to_update, auth()->user()->password);
                if (!$password) {
                    toastr()->error('Password did not match with records!', 'Action Denied');
                    return redirect()->back();
                } else {
                    auth()->user()->update([
                        'email' => $request->email,
                        'guidance_email' => $request->guidance_email,
                        'address' => $request->address,
                    ]);
                }
                // check_image ~ remove ~ add new
                if ($request->has('image')) {
                    File::delete(config('constant.asset_url') . 'student_images/' . auth()->user()->image);
                    $image = Image::make($request->image);
                    $image->resize(150, 150)->encode("png");
                    $image_name = auth()->user()->id . "_profile_image.png";
                    Storage::disk("public")->put(
                        "student_images/" . $image_name,
                        $image
                    );
                    auth()->user()->update([
                        'image' => $image_name
                    ]);
                }
                // check_image ~ report_card ~ add new
                if ($request->has('report_card')) {
                    File::delete(config('constant.asset_url') . 'student_admission_documents/' . auth()->user()->report_card);
                    $academic_report = time() . '_' . auth()->user()->first_name . '_previous_report_card.' . $request->file('report_card')->extension();
                    Storage::disk('public')->put('student_admission_documents/' . $academic_report, file_get_contents($request->file('report_card')));
                    auth()->user()->update([
                        'report_card' => $academic_report
                    ]);
                }
                // check_image ~ birth_certificate ~ add new
                if ($request->has('birth_certificate')) {
                    File::delete(config('constant.asset_url') . 'student_admission_documents/' . auth()->user()->birth_certificate);
                    $birth_certificate = time() . '_' .  auth()->user()->first_name . '_birth_certificate.' . $request->file('birth_certificate')->extension();
                    Storage::disk('public')->put('student_admission_documents/' . $birth_certificate, file_get_contents($request->file('birth_certificate')));
                    auth()->user()->update([
                        'birth_certificate' => $birth_certificate
                    ]);
                }
                toastr()->success('Information updated successfully.', 'Success');
                return redirect()->back();
            } else {
                $password = Hash::check($request->current_password, auth()->user()->password);
                if ($password) {
                    auth()->user()->update([
                        'password' => Hash::make($request->password)
                    ]);
                    toastr()->success('Password changed successsfully', 'Success');
                    return redirect()->back();
                } else {
                    toastr()->error('Password did not match!', 'Try again!');
                    return redirect()->back();
                }
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\PromoteStudent;
use App\User;
use App\Helper\Helper;
use App\AdminNote;
use App\Message;
use Carbon\Carbon;
use App\StudentInfo;
use App\StudentNotification;
use Illuminate\Http\Request;
use App\Jobs\SendSMSJob;
use App\Jobs\SendCustomMailJob;
use App\Current_Semester_Running;
use App\Notifications\AdminNoteNotification;

class HomeController extends Controller
{

	public function index()
	{
		try {
			$admittedStudents = StudentInfo::all();
			$academic_calender = Current_Semester_Running::with('events.type')->get();
            $active_students = PromoteStudent::where('academic_year',Helper::getActiveAcademicYear()->academic_year)->count();
			// return $unReadNotes;
			return view('dashboard', compact('admittedStudents', 'academic_calender','active_students'));
		} catch (\Throwable $th) {
			return $th->getMessage();
		}
	}

	public function sendMailIndex()
	{
		try {
			$students = StudentInfo::orderBy('class', 'asc')->get();
			return view('emails.sendCustom.index', compact('students'));
		} catch (\Throwable $th) {
			return $th->getMessage();
		}
	}

	public function sendMailSend(Request $request)
	{
		try {
			if ($request->studentType == 'active') {
				$studentIDs = StudentInfo::select('id')->where('status', 'active')->pluck('id');
			} elseif ($request->studentType == 'alumni') {
				$studentIDs = StudentInfo::select('id')->where('status', 'alumni')->pluck('id');
			} else {
				$studentIDs = $request->studentIDs;
			}
            $interval = 30;
			foreach ($studentIDs as $studentID) {
				$student = StudentInfo::select('student_id', 'first_name', 'last_name', 'email')->where('id', $studentID)->first();
				$details = array(
					'studentName' => $student->first_name . ' ' . $student->last_name,
					'studentID' => $student->student_id,
					'email' => $student->email,
					'subject' => $request->subject,
					'body' => $request->body
				);
                $job = (new SendCustomMailJob($details))->delay(now()->addSeconds($interval));
                $interval+=30;
                dispatch($job);
			}
			toastr()->success('Mail sent successfully', 'Success');
			return redirect()->back();
		} catch (\Throwable $th) {
			return $th->getMessage();
		}
	}
    public function sendSMSIndex()
    {
        try {
            $messages = Message::where('created_at','>=',Carbon::now()->subDays(7))->get();
            $students = StudentInfo::all();
            return view('sms.sendCustom.index', compact('students','messages'));
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function sendSMSSend(Request $request)
    {
        try {
            if ($request->studentType == 'active') {
                $studentIDs = StudentInfo::select('id')->where('status', 'active')->pluck('id');
            } elseif ($request->studentType == 'alumni') {
                $studentIDs = StudentInfo::select('id')->where('status', 'alumni')->pluck('id');
            } else {
                $studentIDs = $request->studentIDs;
            }
//             return $studentIDs;
            $interval = 30;
            foreach ($studentIDs as $studentID) {
                $student = StudentInfo::select('student_id', 'first_name', 'last_name', 'phone')->where('id', $studentID)->first();
                $details = array(
                    'studentName' => $student->first_name . ' ' . $student->last_name,
                    'studentID' => $student->student_id,
                    'phone' => $student->phone,
                    'body' => $request->body
                );
                $job = (new SendSMSJob($details))->delay(now()->addSeconds($interval));
                $interval+=30;
                dispatch($job);
            }
            toastr()->success('SMS sent successfully', 'Success');
            return redirect()->back();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
  	public function sentSMSPrices()
    {
      try {
        return view('sms.payment.details');
      } catch (\Throwable $th) {
        return $th->getMessage();
      }
    }
    public function sentSMSPricesCalculator(Request $request){
         try {
            $messages = Message::whereBetween('created_at',[$request->from_date,$request->to_date])->get();
             return view('sms.payment.details', compact('messages'));
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
  public function notificationIndex()
	{
		try {
			$students = StudentInfo::all();
			return view('studentNotification.index', compact('students'));
		} catch (\Throwable $th) {
			return $th->getMessage();
		}
	}

	public function notificationSend(Request $request)
	{
		// return $request;
		try {
			if ($request->studentType == config('constant.active')) {
				$studentIDs = StudentInfo::select('id')->where('status', config('constant.active'))->pluck('id');
			} else {
				$studentIDs = $request->studentIDs;
			}
			foreach ($studentIDs as $studentID) {
				StudentNotification::create([
					'studentID' => $studentID,
					'subject' => $request->subject,
					'notification' => $request->body,
					'sentBy' => auth()->user()->id
				]);
			}
			toastr()->success('Notification sent successfully', 'Success');
			return redirect()->back();
		} catch (\Throwable $th) {
			return $th->getMessage();
		}
	}

	public function notificationSentList()
	{
		$notifications = StudentNotification::where('sentBy', auth()->user()->id)->latest()->get();
		return view('studentNotification.list', compact('notifications'));
	}

	public function noteIndex()
	{
		$users = User::all();
		$receivedNotes = AdminNote::with('user')->where('receiver', auth()->user()->id)->get();
		// return $receivedNotes;
		$sentNotes = AdminNote::with('user')->where('sender', auth()->user()->id)->get();
		return view('note.index', compact('users', 'receivedNotes', 'sentNotes'));
	}

	public function noteSend(Request $request)
	{
		foreach ($request->userIDs as $userID) {
			AdminNote::create([
				'sender' => auth()->user()->id,
				'receiver' => $userID,
				'subject' => $request->subject,
				'note' => $request->body
			]);
            User::find($userID)->notify(new AdminNoteNotification($userID));
		}
		toastr()->success('Note sent successfully', 'Success');
		return redirect()->back();
	}

	public function notesClear()
	{
		AdminNote::where('receiver', auth()->user()->id)->update([
			'status' => 2
		]);
		toastr()->success('All notes cleared', 'Clear');
		return redirect()->back();
	}

	public function database_backup()
	{
		try {
			$file = array_diff(
				scandir('public/backup'),
				["..", "."]
			);
			return view('db_backup', compact('file'));
		} catch (\Throwable $th) {
			return $th->getMessage();
		}
	}

    public function markNotificationsRead(){
        try {
            auth()->user()->unreadNotifications->markAsRead();
            return redirect()->back();
        }catch (\Throwable $throwable){
            $throwable->getMessage();
        }
    }
}

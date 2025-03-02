<?php

namespace App\Http\Controllers;

use App\Exam;
use App\StudentExam;
use App\StudentInfo;
use Illuminate\Http\Request;
use App\Imports\StudentExamImport;
use Maatwebsite\Excel\Facades\Excel;

class StudentExamController extends Controller
{
    public function index(){
        try {
            $exams = Exam::all();
            return view('exams.index', compact('exams'));
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function store(Request $request){
        try {
            Exam::create($request->all());
            toastr()->success('Exam added successfully','success');
            return redirect()->back();
        } catch (\Throwable $th) {
             return $th->getMessage();
        }
    }

    public function edit($id){
        try {
            $exam = Exam::find($id);
            return view('exams.edit', compact('exam'));
        } catch (\Throwable $th) {
             return $th->getMessage();
        }
    }

    public function update(Request $request, $id){
        try {
            Exam::find($id)->update($request->except('_token','_method'));
            toastr()->success('Exam updated successfully','success');
            return redirect()->route('exams.index');
        } catch (\Throwable $th) {
             return $th->getMessage();
        }
    }

    public function destroy($id){
        try {
            Exam::destroy($id);
            toastr()->success('Exam deleted successfully','success');
            return redirect()->back();
        } catch (\Throwable $th) {
             return $th->getMessage();
        }
    }

    public function examStudents($id){
        try {
            $examStudents = StudentExam::with('student:studentID,firstName,lastName')->where('examID',$id)->get();
            $exam = Exam::find($id);
            $students = StudentInfo::select('studentID','firstName','lastName')->get();
            return view('exams.examStudents', compact('examStudents', 'exam','students'));
        } catch (\Throwable $th) {
             return $th->getMessage();
        }
    }

    public function examStudentsAdd(Request $request){
        try {
            foreach($request->studentIDs as $studentID){
                $check = StudentExam::where('examID',$request->examID)->where('studentID',$studentID)->Where('date',$request->date)->exists();
                if(!$check){
                    StudentExam::create([
                        'examID' => $request->examID,
                        'studentID' => $studentID,
                        'date' => $request->date,
                        'status' => $request->status
                    ]);
                }
            }
            toastr()->success('Student added successfully','success');
            return redirect()->back();
        } catch (\Throwable $th) {
             return $th->getMessage();
        }
    }


    public function examStudentsDestroy($id){
        try {
            StudentExam::destroy($id);
            toastr()->success('Student deleted successfully','success');
            return redirect()->back();
        } catch (\Throwable $th) {
             return $th->getMessage();
        }
    }
}

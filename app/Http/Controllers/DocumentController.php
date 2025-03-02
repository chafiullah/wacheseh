<?php

namespace App\Http\Controllers;

use App\Document;
use Svg\Tag\Rect;
use App\StudentInfo;
use App\StudentDocument;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $documents = Document::latest()->get();
            // return $documents;
            return view('documents.index', compact('documents'));
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
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
            'title' => 'required|unique:documents'
        ]);
        try {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $file_name = Str::slug($request->title) . '_' . time() . '.' . $extension;
            Storage::disk('public')->put('documents/' . $file_name, file_get_contents($file));
            Document::create([
                'title' => $request->title,
                'file' => $file_name
            ]);
            toastr()->success('File Uploaded Successfully!', 'Success');
            return redirect()->back();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document)
    {
        try {
            Storage::disk('public')->delete('documents/' . $document->file);
            $document->delete();
            toastr()->success('Document deleted successfully!', 'Success');
            return redirect()->back();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    /**
     * ***********************
     * Student wise document store
     * ***********************
     */
    public function student_document_index()
    {
        try {
            $all_student = StudentInfo::select('studentID', 'firstName', 'lastName')->get();
            $students = StudentDocument::with('student:studentID,firstName,lastName,email,phone', 'doc_count')->select('student_id')->distinct('student_id')->get();
            return view('documents.student_index', compact('students', 'all_student'));
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function student_document_store(Request $request)
    {
        try {
            $file = $request->file('file');
            $file_name = $request->studentID . '_' . Str::slug($request->title) . '_' . time() . '.' . $file->extension();
            Storage::disk('public')->put('student_documents/' . $file_name, file_get_contents($file));
            $student_document = StudentDocument::create([
                'student_id' => $request->studentID,
                'file_title' => $request->title,
                'file_name' => $file_name,
                'remarks' => 'none'
            ]);
            $count = StudentDocument::where('student_id', $request->studentID)->count();
            if ($request->input_from == 'single_student') {
                return view('fetched.student_document_item', compact('student_document'));
            } else {
                $students = StudentDocument::with('student:studentID,firstName,lastName,email,phone', 'doc_count')->select('student_id')->distinct('student_id')->get();
                return view('fetched.student_document_index', compact('students'));
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function student_document_list($student_id)
    {
        try {
            $student = StudentInfo::where('studentID', $student_id)->first();
            $documents = StudentDocument::where('student_id', $student_id)->get();
            return view('documents.student_document_list', compact('student', 'documents'));
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function student_document_destroy(StudentDocument $studentDocument)
    {
        try {
            Storage::disk('public')->delete('student_documents/' . $studentDocument->file_name);
            $studentDocument->delete();
            toastr()->success('Document deleted successfully');
            return redirect()->back();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function w9_index()
    {
        try {
            return view('documents.w9.index');
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    public function w9_download(Request $request)
    {
        try {
            $date = Carbon::parse($request->date)->format('m/d/Y');
            $pdf = PDF::loadView('documents.w9.download', ['date' => $date]);
            // return $pdf->stream();
            return $pdf->download('w9_' . $date . '.pdf');
            // return view('registration.ny', ['details' => $studentInfo]);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}

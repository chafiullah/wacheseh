<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Current_Semester_Running;

class Current_Semester_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $semesters = Current_Semester_Running::all();
        // return $semesters;
        return view('current_semester_running.index', compact('semesters'));
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
        try {
            $request->validate([
                'title' => 'required',
                'from' => 'required',
                'to' => 'required',
                'status' => 'required',
            ]);
            // Setting previous semester as 'inactive'
            $current = Current_Semester_Running::where('status', 'active')->first();
            if (isset($current)) { //returns 'yes' if not empty
                $current->status = 'inactive';
                $current->save();
            }

            Current_Semester_Running::create([
                'title' => $request->title,
                'from' => $request->from,
                'to' => $request->to,
                'status' => $request->status
            ]);
            return redirect()->back()->with('msg', 'Semester added successfully!');
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
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
        $semester = Current_Semester_Running::find($id);
        return view('current_semester_running.edit', compact('semester'));
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
        try {
            $request->validate([
                'title' => 'required',
                'from' => 'required',
                'to' => 'required',
                'status' => 'required',
            ]);

            Current_Semester_Running::find($id)->update([
                'title' => $request->title,
                'from' => $request->from,
                'to' => $request->to,
                'status' => $request->status
            ]);
            return redirect()->route('current-semester-running.index')->with('msg', 'Record Updated Successfully');
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $semester = Current_Semester_Running::find($id);
        $semester->delete();

        return redirect()->back()->with('msg', 'Content Deleted Successfully');
    }
}

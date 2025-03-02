<?php

namespace App\Http\Controllers;

use App\Course;
use App\CourseProfile;
use App\CourseProfileCourse;
use App\Department;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        try {
            $courses = Course::all();
            $classes = Department::all();
            return view('course.index', compact('courses', 'classes'));
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    // assigning courses
    public function store(Request $request)
    {
        try {
            Course::create($request->all());
            toastr()->success('Success', 'Subject added successfully');
            return redirect()->back();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function edit($id)
    {
        try {
            $classes = Department::all();
            $course = Course::find($id);
            return view('course.edit', compact('course', 'classes'));
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            Course::where('id', $id)->update($request->except('_token', '_method'));
            toastr()->success('Success', 'Subject updated successfully');
            return redirect()->route('course.index');
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $course = Course::find($id);
            $course->delete();
            toastr()->success('Subject deleted successfully', 'Success');
            return redirect()->route('course.index');
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}

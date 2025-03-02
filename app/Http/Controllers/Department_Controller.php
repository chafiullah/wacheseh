<?php

namespace App\Http\Controllers;

use App\AcademicYear;
use App\Course;
use Illuminate\Http\Request;
use App\Department;
use App\Outline;
use App\OutlineCourse;
use App\OutlineYear;
use App\StudentExam;

class Department_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $departments = Department::all();
            return view('departments.index', compact('departments'));
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
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
        $request->validate([
            'name' => 'required',
        ]);
        Department::create($request->all());
        toastr()->success('Department add successful', 'Success');
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
        $department = Department::find($id);
        return view('departments.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        try {
            $department->update($request->except('_token', '_method'));
            toastr()->success('Department updated successfully', 'Success');
            return redirect()->route('department.index');
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
    public function destroy(Department $department)
    {
        try {
            $department->delete();
            toastr()->success('Department deleted successfully', 'Success');
            return redirect()->back();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function programOutline()
    {
        try {
            $outlines = Outline::with('department')->get();
            $departments = Department::all();
            return view('departments.outline.index', compact('outlines','departments'));
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function programOutlineStore(Request $request)
    {
        //return $request;
        try {
            Outline::updateOrCreate(
                [
                    'class_id' => $request->class_id,
                ],
                [
                    'name' => $request->name,
                ]
            );
            toastr()->success('Outline saved uccessfully', 'Success');
            return redirect()->back();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    public function programOutlineEdit(Outline $outline){
        try {
            $academic_years = AcademicYear::all();
            $departments = Department::all();
            $courses=Course::orderBy('name')->get();
            $outline_years = OutlineYear::where('outline_id',$outline->id)->pluck('academic_year_id')->toArray();
            return view('departments.outline.edit', compact('outline','departments','courses','academic_years','outline_years'));
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    public function programOutlinePatch(Request $request, Outline $outline){
        //return $request;
        try {
            $redundancy=Outline::where('name',$request->name)->where('class_id',$request->class_id)->exists();
            if($redundancy){
                toastr()->error('Data has been duplicated!', 'Denied');
                return redirect()->back();
            }else{
                $outline->update($request->except('_token','_method'));
                toastr()->success('Data has been updated!', 'Success');
                return redirect()->route('programs.outline');
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    public function programOutlineDestroy(Outline $outline)
    {
        try {
            $outline->delete();
            toastr()->success('Outline delete Successfully', 'Success');
            return redirect()->back();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function programOutlineSubjects(Request $request, Outline $outline){
        try {
            // get existing course ids so that we can compare
            $current_courses = OutlineCourse::where('outline_id',$outline->id)->pluck('course_id')->toArray();
            $new_courses = $request->courses;
            // courses to delete
            $delete_courses = array_diff($current_courses,$new_courses);
            $add_courses = array_diff($new_courses,$current_courses);
            // perform the delete operation
            if($delete_courses){
                foreach ($delete_courses as $course) {
                    OutlineCourse::where('outline_id',$outline->id)->where('course_id',$course)->delete();
                }
            }
            // perform the addition
            if($add_courses){
                foreach ($add_courses as $course) {
                    OutlineCourse::create([
                        'outline_id'=>$outline->id,
                        'course_id'=>$course
                    ]);
                }
            }
            toastr()->success('Outline courses updated successfully', 'Success');
            return redirect()->back();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function programOutlineAcademicYears(Request $request, Outline $outline){
        //return $request;
        try {
            // get existing course ids so that we can compare
            $current_years = OutlineYear::where('outline_id',$outline->id)->pluck('academic_year_id')->toArray();
            $new_years = $request->academic_years;
            // courses to delete
            $delete_years = array_diff($current_years,$new_years);
            $add_years = array_diff($new_years,$current_years);
            // perform the delete operation
            if($delete_years){
                foreach ($delete_years as $year) {
                    OutlineYear::where('outline_id',$outline->id)->where('academic_year_id',$year)->delete();
                }
            }
            // perform the addition
            if($add_years){
                foreach ($add_years as $year) {
                    OutlineYear::create([
                        'outline_id'=>$outline->id,
                        'academic_year_id'=>$year
                    ]);
                }
            }
            toastr()->success('Outline years updated successfully', 'Success');
            return redirect()->back();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function general_instruction_index(Request $request, $id)
    {
        try {
            StudentExam::find($id)->update($request->except('_token', '_method'));
            toastr()->success('Information updated successfully', 'Success');
            return redirect()->back();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }


    public function program_instruction_update(Request $request, StudentExam $studentExam)
    {
        try {
            return $studentExam;
            $studentExam->update($request->except('_token', '_method'));
            toastr()->success('Instructions updated successfully!', 'Success');
            return redirect()->back();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}

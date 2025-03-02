<?php

namespace App\Http\Controllers\teachers_evaluation_admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\TE_Question_Category;

class TE_Question_Category_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = TE_Question_Category::all();
        return view('admin_teacher_evaluation.question_category.index',compact('categories'));
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
            'category_name' => 'required'    
        ]);
        
        $category = new TE_Question_Category([
            'category_name' => $request->category_name
        ]);
        
        $category->save();
        return redirect()->back()->with('msg','Category Added Successfully!');
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
        $category = TE_Question_Category::find($id);
        return view('admin_teacher_evaluation.question_category.edit',compact('category'));
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
        $category = TE_Question_Category::find($id);

        $category->category_name = $request->category_name;
        $category->save();

        return redirect()->route('teacher-evaluation-qc.index')->with('msg','Category Updated Successfully!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = TE_Question_Category::find($id);
        $category->delete();

        return redirect()->route('teacher-evaluation-qc.index')->with('msg','Category Updated Successfully!');
    }
}

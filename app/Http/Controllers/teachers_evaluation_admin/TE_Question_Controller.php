<?php

namespace App\Http\Controllers\teachers_evaluation_admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\TE_Question_Category;
use App\TE_Question;
class TE_Question_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $category = TE_Question_Category::find($id);
        $questions = TE_Question::where('question_category',$id)->get();
        return view('admin_teacher_evaluation.question.index',compact('category','questions'));
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
            'question_title' => 'required|string',
            'question_category' => 'required|numeric'
        ]);

        $question = new TE_Question([
            'question_title' => $request->question_title,
            'question_category' => $request->question_category
        ]);
        $question->save();

        return redirect()->back()->with('msg','Question Added Successfully!');
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
        $question = TE_Question::find($id);
        return view('admin_teacher_evaluation.question.edit',compact('question'));
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
        $request->validate([
            'question_title' => 'required|string'
        ]);

        $question = TE_Question::find($id);

        $question->question_title = $request->question_title;
        $question->save();
        return redirect()->route('teacher-evaluation-qs.index',$question->question_category)->with('msg','Question Updated Successfully!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = TE_Question::find($id);
        $question->delete();
        return redirect()->back()->with('msg','Question Deleted Successfully!');
    }
}

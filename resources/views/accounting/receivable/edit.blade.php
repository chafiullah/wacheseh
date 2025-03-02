@extends('layouts.master')

@section('title', 'Course Status | Edit')



@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
          <div class="">
            <span class="text-info">Course Module v1.1 - Implemented On: 31 Dec 2020</span>

            <div class="clearfix"></div>
            <!-- row start -->
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            
                        </div>
                        <div class="x_content">
                            <form action="{{ route('syllabus.update', $course->id) }}" method="POST" enctype="multipart/form-data">
                            @method("PATCH")
                            @csrf
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <label for="">Status:</label>
                                        <select name="status" class="form-control">
                                            <option value="active">active</option>
                                            <option value="inactive">inactive</option>
                                        </select>

                                        <input type="text" hidden name="dept_id" value="{{ $course->department_id }}">
                                        <input type="text" hidden name="session_id" value="{{ $course->session_id }}">
                                        <input type="text" hidden name="level_term" value="{{ $course->level_term }}">
                                    </div>
                                    <div class="col-md-12" style="margin-top: 15px">
                                        <button class="btn btn-success pull-right">submit</button>
                                    </div>
                                </div>
                        </form>
                        </div>
                    </div>
                <!-- row end -->
                </div>
            </div>
        <!-- /page content -->
    </div>
@endsection
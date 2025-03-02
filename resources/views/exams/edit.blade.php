@extends('layouts.master')

@section('title', 'Exams')


@section('content')

    <!-- page content -->
    <div class="right_col" role="main">
          <div class="">
            {{-- <span class="text-info">Course Module v1.1 - Implemented On: 31 Dec 2020</span> --}}
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_content">
                            <form action="{{ route('exams.update',$exam->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method("PATCH")
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="">Exam Name:</label>
                                        <input type="text" name="examName" class="form-control" value="{{ $exam->examName }}">
                                    </div>
                                    
                                    <div class="form-group col-md-12">
                                        <button type="submit" class="btn btn-success btn-md pull-right">update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                <!-- row end -->
                <div class="clearfix"></div>

                </div>
            </div>
        <!-- /page content -->
    </div>

@endsection

@extends('layouts.master')

@section('content')
  <!-- page content -->
  <div class="right_col" role="main">
    <div class="">

      <div class="clearfix"></div>
      <!-- row start -->
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Courses <small> Course basic information.</small></h2>

              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <form class="form-horizontal form-label-left" novalidate method="post" action="{{ route('course.update', $course->id) }}">
                {{ csrf_field() }}
                {{ method_field('patch') }}
                <div class="form-row">
                  <div class="col-md-6">
                    <label for="">Suject Name:</label>
                    <input type="text" name="name" class="form-control" value="{{ $course->name }}">
                  </div>
                  <div class="col-md-6">
                    <label for="">Coefficient:</label>
                    <input type="number" name="coefficient" min="1" value="{{ $course->coefficient }}" class="form-control" required>
                  </div>
                  <div class="col-md-12" style="margin-top: 10px">
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
    @endsection

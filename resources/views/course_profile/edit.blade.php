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
            <div class="x_content">
              <form action="{{ route('course.profile.update', $courseProfile->id) }}" method="post">
                @csrf
                @method('PATCH')
                <div class="form-row">
                  <div class="form-group col-md-12 col-sm-12">
                    <input type="text" name="name" class="form-control" value="{{ $courseProfile->name }}" required>
                  </div>
                  <div class="form-group col-md-12 col-sm-12">
                    <button type="submit" class="btn btn-success pull-right">update</button>
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

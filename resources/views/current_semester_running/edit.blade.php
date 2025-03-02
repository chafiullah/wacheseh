@extends('layouts.master')

@section('title', 'Semester Details')

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
              <h2>Semester Details<small> edit & update</small></h2>

              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <form method="POST" action="{{ route('current-semester-running.update', $semester->id) }}" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                <div class="form-group">
                  <label>Semester Title: </label>
                  <input class="form-control" name="title" placeholder="Semester - Year" value="{{ $semester->title }}" />
                </div>
                <div class="form-group datepicker">
                  <label>Starts From: </label>
                  <input type="date" class="form-control" name="from" value="{{ Carbon\Carbon::parse($semester->from)->format('Y-m-d') }}" />
                </div>
                <div class="form-group">
                  <label>Till: </label>
                  <input type="date" class="form-control" name="to" value="{{ Carbon\Carbon::parse($semester->to)->format('Y-m-d') }}" />
                </div>
                <div class="form-group">
                  <label>Status: </label>
                  <select name="status" class="form-control">
                    <option value="active" @if ($semester->status == 'active') selected @endif>active</option>
                    <option value="inactive" @if ($semester->status == 'inactive') selected @endif>inactive</option>
                  </select>
                </div>
                <div class="form-group">
                  <button class="btn btn-success btn-md pull-right">update</button>
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
  </div>
@endsection

@extends('layouts.master')

@section('title', 'W9 Form')


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
              <h2>Documents</h2>

              <div class="clearfix"></div>
            </div>
            <div class="x_title text-center">
              <h4>Generate the Form Here</h4>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <form action="{{ route('document.w9.download') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="">Date:</label>
                    <input type="date" name="date" class="form-control" required>
                  </div>
                  <div class="form-group col-md-12">
                    <button class="btn btn-success pull-right">generate</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <!-- row end -->
          <div class="clearfix"></div>
        </div>
      </div>
    @endsection

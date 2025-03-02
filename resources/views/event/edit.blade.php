@extends('layouts.master')

@section('title', 'Event Types | Edit')

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
                    <h2>Event Types Edit</h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <form action="{{ route('event-types.update', $type->id) }}" method="POST" enctype="multipart/form-data">
                    @method("PATCH")    
                    @csrf
                        <div class="form-row">
                          <div class="col-md-6">
                            <label for="">Title:</label>
                            <input type="text" class="form-control" name="title" value="{{ $type->title }}">
                          </div>
                          <div class="col-md-6">
                            <label for="">Status:</label>
                            <select name="status" class="form-control">
                              <option value="active">active</option>
                              <option value="inactive">inactive</option>
                            </select>
                          </div>
                          <div class="col-md-12" style="margin-top: 10px">
                            <button type="submit" class="btn btn-success btn-md pull-right">submit</button>
                          </div>
                        </div>
                      </form>
                  </div>
                </div>
              <!-- row end -->
              <div class="clearfix"></div>

          </div>
@endsection

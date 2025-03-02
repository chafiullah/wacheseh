@extends('layouts.master')

@section('title', 'Semester Events Edit')

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
              <h2>Semester Events</h2>

              <div class="clearfix"></div>
            </div>
            <div class="x_title text-right">
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <form method="POST" action="{{ route('semester-event.update', $event->id) }}" enctype="multipart/form-data">
                @csrf
                @method("PATCH")
                <div class="form-group">
                  <label>Semester Title: </label>
                  <input class="form-control" name="session_id" value="{{ $event->session_id }}" readonly>
                </div>

                <div class="form-group">
                  <label>Event: </label>
                  <select name="type_id" class="form-control" required>
                    @foreach ($types as $item)
                      <option value="{{ $item->id }}" @if ($item->id == $event->type_id) selected @endif>{{ $item->title }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="form-group">
                  <label>Starts From: </label>
                  <input type="date" class="form-control" name="starts" value="{{ Carbon\Carbon::parse($event->starts)->format('Y-m-d') }}" />
                </div>

                <div class="form-group">
                  <label>Ends at: </label>
                  <input type="date" class="form-control" name="ends" value="{{ Carbon\Carbon::parse($event->ends)->format('Y-m-d') }}" />
                </div>

                <div class="form-group">
                  <label>Remarks: </label>
                  <textarea name="remarks" class="form-control">{{ $event->remarks }}</textarea>
                </div>

                <div class="form-group">
                  <button class="btn btn-success btn-md pull-right">submit</button>
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

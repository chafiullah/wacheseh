@extends('layouts.master')

@section('title', 'Refund Form')


@section('content')
  <!-- page content -->
  <div class="right_col" role="main">
    <div class="">
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-12">
          {{-- Student Portal Features --}}
          <div class="x_panel">
            {{-- department wise students --}}
            <div class="x_title">
              <h4 class="text-info">Withdrawn Student Refund Form</h4>
              <div class="clearfix"></div>
            </div>

            <div class="x_content">
              <form action="{{ route('withdrawn.refund.generate') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group col-md-12">
                  <label for="">Select Student:</label>
                  <select name="student_id" class="form-control select2">
                    <option></option>
                    @foreach ($students as $item)
                      <option value="{{ $item->studentID }}">{{ $item->studentID . ' - ' . $item->firstName . ' ' . $item->lastName }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-md-12">
                  <button type="submit" class="btn btn-success pull-right">submit</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /page content -->
@endsection

@section('extrascript')
  <script>
    $(document).ready(function() {
      $(".select2").select2({
        placeholder: "Select Student...",
        allowClear: true
      });
    });
  </script>
@endsection

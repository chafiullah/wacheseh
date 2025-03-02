@extends('layouts.master')

@section('title', 'Grade Book')

@section('extrastyle')
  <link href="{{ URL::asset('assets/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('assets/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('assets/css/buttons.bootstrap.min.css') }}" rel="stylesheet">

@endsection

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
              <div class="form-group">
                <label for="">Select a course:</label>
                <select id="selected_course" class="form-control select2" onchange="get_grades()">
                  <option></option>
                  @foreach ($courses as $item)
                    <option value="{{ $item->course->id }}">{{ $item->course->course_code . ' ' . $item->course->course_name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          <!-- row end -->
          <div class="clearfix"></div>
          <div class="x_panel" id="students_grade_table">

          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /page content -->
@endsection
@section('extrascript')
  <script src="{{ URL::asset('assets/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/dataTables.bootstrap.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/dataTables.buttons.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/buttons.bootstrap.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/buttons.flash.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/buttons.html5.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/buttons.print.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/jszip.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/pdfmake.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/vfs_fonts.js') }}"></script>
  <script>
    $(document).ready(function() {
      $(".select2").select2({
        placeholder: "select a course...",
        allowClear: true
      });
    });
  </script>

  <script>
    function get_grades() {
      let course_id = $("#selected_course").val();
      let path = "{{ route('teacher.grade.get') }}";
      $.ajax({
        type: "get",
        url: path,
        data: {
          'course_id': course_id
        },
        dataType: "html",
        success: function(response) {
          $("#students_grade_table").empty();
          $("#students_grade_table").html(response);
        }
      });
    }
  </script>
@endsection

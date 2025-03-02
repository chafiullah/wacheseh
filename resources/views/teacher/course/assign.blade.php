@extends('layouts.master')

@section('title', 'Teachers Courses')

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
          @if (count($teacher_course_profiles) == 0)
            <div class="x_panel">
              <div class="x_title">
                <h3>Assign Course Profile to {{ $teacher->name }}</h3>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <form action="{{ route('teacher.assign.course.store') }}" method="post">
                  @csrf
                  <div class="form-row">
                    <div class="form-group col-md-12">
                      <label for="">Tacher ID:</label>
                      <input type="text" name="teacher_id" class="form-control" value="{{ $teacher->id }}" readonly>
                    </div>
                    <div class="form-group col-md-12">
                      <label for="">Select Course Profile:</label>
                      <select name="profile_ids[]" class="select2 form-control" multiple>
                        <option></option>
                        @foreach ($course_profiles as $item)
                          <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group col-md-12">
                      <button class="btn btn-success pull-right" type="submit">assign</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <!-- row end -->
            <div class="clearfix"></div>
          @endif
          <div class="x_panel">
            <div class="x_content">
              <table id="datatable-buttons" class="table table-striped">
                <thead>
                  <tr>
                    <th>Course</th>
                    <th>Coefficient</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($teacher_course_profiles as $teacher_course_profile)
                    @foreach ($teacher_course_profile->course_profile->course_profile_courses as $item)
                      <tr>
                        <td>{{ $item->course->course_name }}</td>
                        <td>{{ $item->course->coefficient }}</td>
                      </tr>
                    @endforeach
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /page content -->
@endsection
@section('extrascript')
  <!-- dataTables -->
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
        placeholder: "select profile....."
      });
    });
  </script>
  <script>
    $(document).ready(function() {
      //datatables code
      var handleDataTableButtons = function() {
        if ($("#datatable-buttons").length) {
          $("#datatable-buttons").DataTable({
            responsive: true,
            dom: "Bfrtip",
            "aaSorting": [],
            buttons: [{
                extend: "copy",
                className: "btn-sm"
              },
              {
                extend: "csv",
                className: "btn-sm"
              },
              {
                extend: "excel",
                className: "btn-sm"
              },
              {
                extend: "pdfHtml5",
                className: "btn-sm"
              },
              {
                extend: "print",
                className: "btn-sm"
              },
            ],
            responsive: true
          });
        }
      };
      TableManageButtons = function() {
        "use strict";
        return {
          init: function() {
            handleDataTableButtons();
          }
        };
      }();
      TableManageButtons.init();
    });
  </script>
  <!-- /validator -->
@endsection

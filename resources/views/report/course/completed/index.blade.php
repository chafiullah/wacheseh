@extends('layouts.master')

@section('title', 'Student Completed courses')

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
              <form action="{{ route('report.course.completed.list') }}" method="post">
                @csrf
                <div class="form-row">
                  <div class="col-md-12 form-group">
                    <label for="">Select Year:</label>
                    <select name="year" id="selected_year" class="select2 form-control" required>
                      <option></option>
                      <option value="2017">2017</option>
                      <option value="2018">2018</option>
                      <option value="2019">2019</option>
                      <option value="2020">2020</option>
                      <option value="2021">2021</option>
                      <option value="2022">2022</option>
                    </select>
                  </div>
                  <div class="col-md-12 form-group">
                    <label for="">Select Program:</label>
                    <select name="program" id="program_id" class="form-control select2" required>
                      <option></option>
                      @foreach ($programs as $item)
                        <option value="{{ $item->id }}">{{ $item->short_name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-md-12">
                    <label for="">Select Students:</label>
                    <select name="student_ids[]" id="student_ids" class="form-control select2" multiple>

                    </select>
                  </div>
                  <div class="col-md-12 form-group">
                    <button type="submit" class="btn btn-success pull-right">generate</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <!-- row end -->
          <div class="clearfix"></div>
          <div class="x_panel">
            <div class="x_content table-responsive">
              <table class="table table-striped data-table" style="font-size: 13px !important">
                <thead>
                  <tr>
                    <th>Student ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Degree</th>
                    <th>Phone</th>
                    <th>Student Session</th>
                    <th>Completed Courses</th>
                  </tr>
                <tbody>
                  @foreach ($student_list as $item)
                    <tr>
                      <td>{{ $item->studentID }}</td>
                      <td>{{ $item->firstName }}</td>
                      <td>{{ $item->lastName }}</td>
                      <td>{{ $item->degreeProgram }}</td>
                      <td>{{ $item->phone }}</td>
                      <td>{{ Carbon\Carbon::parse($item->studentSession)->format('m/d/Y') }}</td>
                      <td>
                        <table class="table table-striped data-table" style="font-size: 13px !important">
                          <thead>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Grade</th>
                            <th>Started</th>
                            <th>Ended</th>
                          </thead>
                          <tbody>
                            @foreach ($item->marks as $mark)
                              <tr>
                                <td>{{ $mark->course->course_code }}</td>
                                <td>{{ $mark->course->course_name }}</td>
                                <td>{{ $mark->grade_letter }}</td>
                                <td>{{ $mark->courseStarted }}</td>
                                <td>{{ $mark->courseEnded }}</td>
                              </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
                </thead>
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
      $('.select2').select2({
        placeholder: 'select particular..',
        allowClear: true
      });
      //datatables code
      var handleDataTableButtons = function() {
        if ($(".data-table").length) {
          $(".data-table").DataTable({
            responsive: true,
            dom: "Bfrtip",
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
  <script>
    $("#program_id").on('change', function() {
      $.LoadingOverlay("show");
      let selected_year = $("#selected_year").val();
      let program_id = $("#program_id").val();
      console.log(selected_year + ':' + program_id);
      $.ajax({
        type: "get",
        url: "{{ route('report.course.leftover.students') }}",
        data: {
          'year': selected_year,
          'program': program_id
        },
        dataType: "html",
        success: function(response) {
          $.LoadingOverlay("hide");
          $("#student_ids").html(response);
        }
      });
    });
  </script>
  <!-- /validator -->
@endsection

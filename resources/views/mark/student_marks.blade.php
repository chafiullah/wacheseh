@extends('layouts.master')

@section('extrastyle')
  <link href="{{ URL::asset('assets/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
  {{-- <link href="{{ URL::asset('assets/css/responsive.dataTables.min.css')}}" rel="stylesheet"> --}}
  <link href="{{ URL::asset('assets/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('assets/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('assets/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('content')

  <!-- page content -->
  <div class="right_col" role="main">
    <div class="">
      <div class="clearfix"></div>
      <!-- row start -->
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          @if (Request::routeIs('student-marks.index'))
            <div class="x_panel">
              <div class="x_title">
                <h2>Marks<small>Single student all marks information.</small></h2>
                <div class="clearfix"></div>
              </div>
              <div class="x_panel">
                <form method="POST" action="{{ route('student-marks.show') }}">
                  @csrf
                  <div class="form-row">
                    <div class="form-group col-md-3 col-sm-12">
                      <label for="">Select Semester: <span class="text-danger">*</span></label>
                      <select name="semester" class="form-control" required>
                        <option value="{{ config('constant.sem1') }}">{{ config('constant.sem1') }}</option>
                        <option value="{{ config('constant.sem2') }}">{{ config('constant.sem2') }}</option>
                        <option value="{{ config('constant.sem3') }}">{{ config('constant.sem3') }}</option>
                      </select>
                    </div>
                    <div class="form-group col-md-3 col-sm-12">
                      <label for="">Academic Year: <span class="text-danger">*</span></label>
                      <select name="academic_year" class="form-control subject" id="academic_year" required>
                        <option></option>
                        @foreach ($academic_years as $year)
                          <option value="{{ $year->academic_year }}" @if(\App\Helper\Helper::getActiveAcademicYear()->academic_year==$year->academic_year )selected @endif>
                            {{ $year->alias }}
                          </option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group col-md-3 col-sm-12">
                      <label for="">Class: <span class="text-danger">*</span></label>
                      <select name="class_id" class="form-control subject" id="class_id" required>
                        <option></option>
                        @foreach ($classes as $class)
                          <option value="{{ $class->id }}">
                            {{ $class->name }}
                          </option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group col-md-3 col-sm-12">
                      <label for="">Select Student: <span class="text-danger">*</span></label>
                      <select name="student_id" class="form-control" id="student_list" required>
                      </select>
                      <small class="text-danger" id="waiting_message"></small>
                    </div>
                    <div class="form-group col-md-12 col-sm-12">
                      <button type="submit" class="btn btn-success pull-right">show grades</button>
                    </div>
                  </div>
                </form>
                <div class="clearfix"></div>
              </div>
              <div class="clearfix"></div>
            </div>
          @endif
          @if (Request::routeIs('student-marks.show'))
            <div class="x_panel">
              <div class="x_title">
                <h2>All Grades of <b>{{ $student->name }}</b> / <b>{{ $marks->first()->semester }}</b> / <b>{{ $marks->first()->class_id }}</b></h2>
                <div class="clearfix"></div>
              </div>
              <div class="x_panel">
                <table class="table table-striped" id="datatable-buttons">
                  <thead>
                    <tr>
                      <th>Subject Name</th>
                      <th>N1</th>
                      <th>N2</th>
                      <th>Average (N=(N1+N2)/2)</th>
                      <th>Coef. (C)</th>
                      <th>N*C</th>
                      <th>Grade</th>
                      <th>Signature</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($marks as $item)
                      @php
                        $average = ($item->n1_mark + $item->n2_mark) / 2;
                      @endphp
                      <tr>
                        <td>{{ $item->course_id->name }}</td>
                        <td>{{ $item->n1_mark }}</td>
                        <td>{{ $item->n2_mark }}</td>
                        <td>{{ $average }}</td>
                        <td>{{ $item->course_id->coefficient }}</td>
                        <td>{{ $average * $item->course_id->coefficient }}</td>
                        <td>{{ $item->grade }}</td>
                        <td>{{ $item->signature }}</td>
                        <td>
                          @permission('edit-marks')
                            <a href="{{ route('mark.edit', $item->id) }}" class="btn btn-sm btn-warning"><i class="fa fa-edit" aria-hidden="true"></i></a>
                          @endpermission

                          @permission('delete-marks')
                            <a href="{{ route('mark.destroy', $item->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this mark?')"><i class="fa fa-trash"
                                aria-hidden="true"></i></a>
                          @endpermission
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
                <div class="clearfix"></div>
              </div>
              <div class="clearfix"></div>
            </div>
          @endif
        </div>
      </div>
      <!-- row end -->
      <div class="clearfix"></div>
    </div>
  </div>
  <!-- /page content -->
@endsection
@section('extrascript')
  <!-- dataTables -->
  <script src="{{ URL::asset('assets/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/dataTables.bootstrap.min.js') }}"></script>
  {{-- <script src="{{ URL::asset('assets/js/dataTables.responsive.min.js')}}"></script> --}}
  <script src="{{ URL::asset('assets/js/dataTables.buttons.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/buttons.bootstrap.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/buttons.flash.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/buttons.html5.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/buttons.print.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/jszip.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/pdfmake.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/vfs_fonts.js') }}"></script>
  <script src="{{ URL::asset('assets/js/sweetalert.min.js') }}"></script>

  <script>
    $(document).ready(function() {
      //datatables code
      var handleDataTableButtons = function() {
        if ($("#datatable-buttons").length) {
          $("#datatable-buttons").DataTable({
            responsive: true,
            dom: "Bfrtip",
            buttons: [{
              extend: "excel",
              className: "btn-sm"
            }, ],
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
    $(document).ready(function() {
      $(".subject").select2({
        placeholder: "Select a value",
        allowClear: true
      });
    });
  </script>
  <!-- /validator -->
  <script>
    $(document).ready(function() {
      $("#class_id").on("change", function() {
        $("#waiting_message").empty();
        $("#waiting_message").text("Please wait till the list loads.....");
        var class_id = $("#class_id").val();
        var academic_year = $("#academic_year").val();
        if (academic_year === ''){
          alert('You have to select academic year first!');
          $("#waiting_message").text('Please select both academic year and class');
          $("#class_id").clear();
        }
        var path = "{{ route('get-student.list') }}";
        // console.log(class_id);
        $.ajax({
          type: "get",
          url: "{{ route('get-student.list') }}",
          data: {
            "class_id": class_id,
            "academic_year":academic_year
          },
          dataType: "html",
          success: function(response) {
            $("#student_list").empty();
            $("#student_list").html(response);
            $("#waiting_message").empty();
          }
        });
      });
    });
  </script>
@endsection

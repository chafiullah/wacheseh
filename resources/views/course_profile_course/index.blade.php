@extends('layouts.master')

@section('extrastyle')
  <link href="{{ URL::asset('assets/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
  {{-- <link href="{{ URL::asset('assets/css/responsive.dataTables.min.css')}}" rel="stylesheet"> --}}
  <link href="{{ URL::asset('assets/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('assets/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('assets/css/sweetalert.css') }}" rel="stylesheet">
@endsection

@section('content')
  <!-- page content -->
  <div class="right_col" role="main">
    <div class="">
      {{-- <span class="text-info">Course Module v1.1 - Implemented On: 31 Dec 2020</span> --}}
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <div class="clearfix"></div>
              @permission('add-subject')
                <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target=".bd-example-modal-lg" style="margin-top: 15px">+ Add New Courses</button>
              @endpermission
            </div>
            <div class="x_content">
              <table id="datatable-buttons" class="table table-striped table-bordered" style="font-size: 14px">
                <thead>
                  <tr>
                    <th>Class</th>
                    <th>Course</th>
                    <th>Coefficient</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($course_profile_courses as $item)
                    <tr>
                      <td>{{ $item->course->department->name }}</td>
                      <td>{{ $item->course->course_name }}</td>
                      <td>{{ $item->course->coefficient }}</td>
                      <td>
                        <a href="{{ route('course.profile.course.destroy', $item->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete this item?')"><i
                            class="fa fa-trash" aria-hidden="true"></i></a>
                        @permission('assign-students-to-this-subject')
                          {{-- assign student --}}
                          <a href="{{ route('enroll.students.index', $item->course->id) }}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="enroll-students"><i
                              class="fas fa-plus    "></i>&nbsp;<i class="fas fa-users    "></i></a>
                        @endpermission
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
          <!-- row end -->
          <div class="clearfix"></div>
        </div>
      </div>
      <!-- /page content -->
    </div>
    {{-- modal --}}
    <div class="modal fade bd-example-modal-lg" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-content">
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_content">
                    <form action="{{ route('course.profile.course.store') }}" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="form-row">
                        <div class="form-group col-md-12 col-sm-12">
                          <label for="">Profile ID:</label>
                          <input type="text" name="profile_id" value="{{ $courseProfile->id }}" class="form-control" readonly>
                        </div>
                        <div class="form-group col-md-12 col-sm-12">
                          <label for="">Select Courses:</label>
                          <select name="course_ids[]" class="select2 form-control" multiple required>
                            <option></option>
                            @foreach ($courses as $course)
                              <option value="{{ $course->id }}">{{ $course->course_name }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="form-group col-md-12 col-sm-12">
                          <button type="submit" class="btn btn-success btn-md pull-right">submit</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
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
    <script>
      $(document).ready(function() {

        //datatables code
        var handleDataTableButtons = function() {
          if ($("#datatable-buttons").length) {
            $("#datatable-buttons").DataTable({
              "pageLength": 10,
              responsive: true,
              order: [],
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
      $(document).ready(function() {
        $(".select2").select2({
          placeholder: "select courses...",
          allowClear: true,
          dropdownParent: $(".bd-example-modal-lg")
        });
      });
    </script>
    <!-- /validator -->
  @endsection

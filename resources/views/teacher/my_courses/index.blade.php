@extends('layouts.master')

@section('title', 'My Courses')

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
            <div class="x_title">
              <h3>My Courses || Grade Book of {{\App\Helper\Helper::getActiveAcademicYear()->alias}}</h3>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <table id="datatable-buttons" class="table table-striped">
                <thead>
                  <tr>
                    <th>Course Name</th>
                    <th>Coefficient</th>
                    <th>Class</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($course_profiles as $course_profile)
                    @foreach ($course_profile->course_profile->course_profile_courses as $item)
                      <tr>
                        <td>{{ $item->course->course_name }}</td>
                        <td>{{ $item->course->coefficient }}</td>
                        <td>{{ $item->course->department->name }}</td>
                        <td>
                          <a href="{{ route('teacher.grade.book.generate', [$item->course->department->id, $item->course->id,config('constant.sem1')]) }}" class="btn btn-success btn-sm" data-toggle="tooltip"
                            data-placement="top" title="add-grades"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Grade Book of |
                            {{config('constant.sem1')}}</a>
                          <a href="{{ route('teacher.grade.book.generate', [$item->course->department->id, $item->course->id,config('constant.sem2')]) }}" class="btn btn-info btn-sm" data-toggle="tooltip"
                             data-placement="top" title="add-grades"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Grade Book of |
                            {{config('constant.sem2')}}</a>
                          <a href="{{ route('teacher.grade.book.generate', [$item->course->department->id, $item->course->id,config('constant.sem3')]) }}" class="btn btn-warning btn-sm" data-toggle="tooltip"
                             data-placement="top" title="add-grades"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Grade Book of |
                            {{config('constant.sem3')}}</a>
                        </td>
                      </tr>
                    @endforeach
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
          <!-- row end -->
          <div class="clearfix"></div>
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
        placeholder: "select courses....."
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

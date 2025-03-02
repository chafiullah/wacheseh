@extends('layouts.master')

@section('title', 'Teachers')

@section('extrastyle')
  <link href="{{ URL::asset('assets/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('assets/css/responsive.dataTables.min.css') }}" rel="stylesheet">
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
              <h3>Teachers</h3>
              @role('super-admin')
                <a href="{{ route('user.index') }}" class="btn btn-info pull-right"><i class="fa fa-user-plus" aria-hidden="true"></i> add new teacher</a>
              @endrole
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <table id="datatable-buttons" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($teachers as $item)
                    <tr>
                      <td>{{ $item->name }}</td>
                      <td>
                      @permission('assign-courses-to-this-subject')
                        <a href="{{ route('teacher.assign.course', $item->id) }}" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="assign-course-profile"><i class="fa fa-book"
                            aria-hidden="true"></i></a>
                      @endpermission
                      @permission('remove-course-profile')
                        @if (count($item->course_profile) > 0)
                          <a href="{{ route('teacher.remove.course.profiles', $item->id) }}" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="remove-course-profile"><i
                              class="fa fa-book" aria-hidden="true"></i></a>
                        @endif
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
    </div>
  </div>
  <!-- /page content -->
@endsection
@section('extrascript')
  <!-- dataTables -->
  <script src="{{ URL::asset('assets/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/dataTables.bootstrap.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/dataTables.responsive.min.js') }}"></script>
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

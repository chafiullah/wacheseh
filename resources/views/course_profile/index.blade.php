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
                <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target=".bd-example-modal-lg" style="margin-top: 15px">+ Add New Profile</button>
              @endpermission
            </div>
            <div class="x_content">
              <table id="datatable-buttons" class="table table-striped table-bordered" style="font-size: 14px">
                <thead>
                  <th>Database ID</th>
                  <th>Profile Name</th>
                  <th>Action</th>
                </thead>
                <tbody>

                  @foreach ($course_profiles as $profile)
                    <tr>
                      <td>{{ $profile->id }}</td>
                      <td>{{ $profile->name }}</td>
                      <td>
                        @permission('edit-subject')
                          <a href="{{ route('course.profile.edit', $profile->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit    "></i></a>
                        @endpermission

                        @permission('delete-subject')
                          <a href="{{ route('course.profile.destroy', $profile->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to remove this item?')"><i
                              class="fas fa-trash    "></i></a>
                        @endpermission

                        @permission('assign-students-to-this-subject')
                          <a href="{{ route('course.profile.course.list', $profile->id) }}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top"
                            title="add courses in under this profile"><i class="fas fa-plus    "></i>&nbsp;<i class="fas fa-book"></i></a>
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
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-content">
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_content">
                    <form action="{{ route('course.profile.store') }}" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="form-row">
                        <div class="form-group col-md-12 col-sm-12">
                          <label for="">Profile Name:</label>
                          <input type="text" name="name" class="form-control" required>
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
    <script src="{{ URL::asset('assets/js/sweetalert.min.js') }}"></script>

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
    <!-- /validator -->
  @endsection

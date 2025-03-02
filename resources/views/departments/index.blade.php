@extends('layouts.master')

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
              <h2>Classes</h2>

              <div class="clearfix"></div>
            </div>
            <div class="x_title text-right">
              @role('super-admin')
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">+ Add New</button>
              @endrole
              <div class="clearfix"></div>
            </div>
            @if ($errors->any())
              <div class="alert alert-danger">
                <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif
            <div class="x_content table-responsive">
              <table id="datatable-buttons" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Database ID (non-changeable)</th>
                    <th>Class Name</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($departments as $dept)
                    <tr>
                      <td>{{ $dept->id }}</td>
                      <td>{{ $dept->name }}</td>
                      <td>
                        @role('super-admin')
                          <a href="{{ route('department.edit', $dept->id) }}" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                        @endrole

                        @role('super-admin')
                          <a href="{{ route('department.destroy', $dept->id) }}" class="btn btn-danger"
                            onclick="return confirm('Are you sure to delete this class? Deleting class may affect other information in student database!')"><i class="fa fa-trash"></i></a>
                        @endrole
                        @permission('assign-courses-to-this-subject')
                          {{-- assign student --}}
                          <a href="{{ route('enroll.students.index', $dept->id) }}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="enroll-courses"><i
                              class="fa fa-book"></i></a>
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
      <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="clearfix"></div>
            <!-- row start -->
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Classes:</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <form method="POST" action="{{ route('department.store') }}" enctype="multipart/form-data">
                      @csrf
                      <div class="form-group">
                        <label>Name: </label>
                        <input class="form-control" name="name" required />
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
          </div>
        </div>
      </div>
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

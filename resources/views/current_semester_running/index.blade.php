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
              <h2>Semester Details</h2>

              <div class="clearfix"></div>
            </div>
            <div class="x_title text-right">
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">+ Add New</button>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              @if (Session::has('msg'))
                <div class="alert alert-success">
                  {!! \Session::get('msg') !!}
                </div>
              @endif
              <table id="datatable-buttons" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Database ID</th>
                    <th>Semester Title</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($semesters as $semester)
                    <tr>
                      <td>{{ $semester->id }}</td>
                      <td>{{ $semester->title }}</td>
                      <td>{{ $semester->from }}</td>
                      <td>{{ $semester->to }}</td>
                      <td>
                        @if ($semester->status == 'active')
                          <span class="text-success">active</span>
                        @else
                          <span class="text-danger">inactive</span>
                        @endif
                      </td>
                      <td>
                        @permission('can-manage-events')
                          <a href="{{ route('semester-event.index', $semester->id) }}" class="btn btn-info"><i class="fa fa-cog"></i> manage-events</a>
                        @endpermission

                        @permission('can-manage-sessions')
                          <a href="{{ route('current-semester-running.edit', $semester->id) }}" class="btn btn-warning"><i class="fa fa-edit"></i> edit</a>

                          <a href="{{ route('current-semester-running.destroy', $semester->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i> delete</a>
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
  </div>

  <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="clearfix"></div>
        <!-- row start -->
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Add Semester Details</h2>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <form method="POST" action="{{ route('current-semester-running.store') }}" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group">
                    <label>Semester Title: </label>
                    <input class="form-control" name="title" placeholder="Semester - Year" />
                  </div>
                  <div class="form-group datepicker">
                    <label>Starts From: </label>
                    <input type="date" class="form-control" name="from" />
                  </div>
                  <div class="form-group">
                    <label>Till: </label>
                    <input type="date" class="form-control" name="to" />
                  </div>
                  <div class="form-group">
                    <label>Status: </label>
                    <select name="status" class="form-control">
                      <option value="active">active</option>
                      <option value="inactive">inactive</option>
                    </select>
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
            ordering: false,
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

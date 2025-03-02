@extends('layouts.master')

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
              <h2>Event Types</h2>

              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target=".bd-example-modal-lg">+ Add Event Type</button>
              <table id="datatable-buttons" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Database ID</th>
                    <th>Title</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($types as $type)
                    <tr>
                      <td>{{ $type->id }}</td>
                      <td>{{ $type->title }}</td>
                      <td>
                        @permission('can-manage-events')
                          <a href="{{ route('event-types.edit', $type->id) }}" class="btn btn-warning btn-sm"> <i class="fas fa-edit"></i> edit</a>
                        @endpermission

                        @permission('can-manage-events')
                          <a href="{{ route('event-types.destroy', $type->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?');"> <i
                              class="fas fa-trash"></i> delete</a>
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
        {{-- modal --}}
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="clearfix"></div>
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_content">
                      <form action="{{ route('event-types.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                          <div class="col-md-6">
                            <label for="">Title:</label>
                            <input type="text" class="form-control" name="title">
                          </div>
                          <div class="col-md-6">
                            <label for="">Status:</label>
                            <select name="status" class="form-control">
                              <option value="active">active</option>
                              <option value="inactive">inactive</option>
                            </select>
                          </div>
                          <div class="col-md-12" style="margin-top: 10px">
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

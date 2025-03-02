@extends('layouts.master')

@section('title', 'Documents')

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
              <h2>Documents</h2>

              <div class="clearfix"></div>
            </div>
            <div class="x_title text-right">
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">+ Add New</button>
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
                    <th>#</th>
                    <th>Title</th>
                    <th>Uploaded on</th>
                    <th>Downloadable Link</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($documents as $item)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $item->title }}</td>
                      <td>{{ $item->created_at }}</td>
                      <td>
                        <a href="{{ Storage::url('app/public/documents/' . $item->file) }}" download="">click to download</a>
                      </td>
                      <td>
                        <a href="{{ Storage::url('app/public/documents/' . $item->file) }}" class="btn btn-success btn-sm" target="_blank"><i class="fas fa-eye    "></i></a>
                        <a href="{{ route('document.destroy', $item->id) }}" class="btn btn-danger btn-sm"><i class="fas fa-trash    "></i></a>
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
                    <h2>Documents</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <form method="POST" action="{{ route('document.store') }}" enctype="multipart/form-data">
                      @csrf
                      <div class="form-group">
                        <label>Title: </label>
                        <input type="text" class="form-control" name="title" />
                      </div>
                      <div class="form-group">
                        <label>File: </label>
                        <input type="file" class="form-control" name="file" />
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

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
                    <th>Academic Year</th>
                    <th>Alias</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($academic_years as $year)
                    <tr>
                      <td>{{$year->id}}</td>
                      <td>{{$year->academic_year}}</td>
                      <td>{{$year->alias}}</td>
                      <td class="{{$year->status == 'active' ? 'text-success':'text-danger'}}">{{$year->status}}</td>
                      <td>
                        @if($year->status == 'inactive')
                          <a class="btn btn-success btn-sm" href="{{route('academicYear.active',$year->id)}}" onclick="return confirm('Are you sure to active this academic year? This action is not revertible!')">activate</a>
                        @endif
                        <a class="btn btn-danger btn-sm" href="{{route('academicYear.destroy',$year->id)}}" onclick="return confirm('Are you sure to delete this item? This action is not revertible!')">delete</a>
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
                    <form method="POST" action="{{ route('academicYear.add') }}" enctype="multipart/form-data">
                      @csrf
                      <div class="form-group col-md-6 col-sm-12">
                        <label>Academic Year: </label>
                        <input class="form-control" type="number" min="2000" name="academic_year" required />
                      </div>
                      <div class="form-group col-md-6 col-sm-12">
                        <label>Alias: </label>
                        <input class="form-control" type="text" name="alias" required />
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

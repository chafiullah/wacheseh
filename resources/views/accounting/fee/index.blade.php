@extends('layouts.master')

@section('title', 'FeeList')
@section('extrastyle')
  <link href="{{ URL::asset('assets/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
  {{-- <link href="{{ URL::asset('assets/css/responsive.dataTables.min.css')}}" rel="stylesheet"> --}}
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
              <h2>Fee<small> Basic information.</small></h2>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <div class="row">
                <div class="col-md-12">
                  <form action="{{ route('fee.store') }}" method="post">
                    @csrf
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label for="">Fee Title: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="feeTitle" placeholder="Tuition Fee" required>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="">Minimum Payable Amount: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="payableAmount" placeholder="Amount in FCFA" required>
                      </div>
                    </div>
                    <div class="form-group col-md-12">
                      <button class="btn btn-success btn-md pull-right">submit</button>
                    </div>
                  </form>
                </div>
              </div>
              {{-- all fees --}}
              <div class="row">
                <div class="col-md-12">
                  <table class="table table-striped" id="datatable-buttons">
                    <thead>
                      <th>Fee Title</th>
                      <th>Minimum Payable Amount in FCFA</th>
                      <th>Actions</th>
                    </thead>
                    <tbody>
                      @foreach ($fees as $item)
                        <tr>
                          <td>{{ $item->feeTitle }}</td>
                          <td>{{ $item->payableAmount }}</td>
                          <td>
                            <a href="{{ route('fee.edit', $item->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit    "></i></a>
                            <a href="{{ route('fee.destroy', $item->id) }}" class="btn btn-danger btn-sm"><i class="fas fa-trash    "></i></a>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
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

@extends('layouts.master')

@section('title', 'Programs')

@section('extrastyle')
  <link href="{{ URL::asset('assets/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('assets/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('assets/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  {{-- loading animation --}}
  <style>
    .rotate-center {
      -webkit-animation: rotate-center .6s ease-in-out infinite both;
      animation: rotate-center .6s ease-in-out infinite both
    }

    @-webkit-keyframes rotate-center {
      0% {
        -webkit-transform: rotate(0);
        transform: rotate(0)
      }

      100% {
        -webkit-transform: rotate(360deg);
        transform: rotate(360deg)
      }
    }

    @keyframes rotate-center {
      0% {
        -webkit-transform: rotate(0);
        transform: rotate(0)
      }

      100% {
        -webkit-transform: rotate(360deg);
        transform: rotate(360deg)
      }
    }

  </style>
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
              <h2>Student Documents</h2>

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
            <div class="x_content table-responsive" id="document_content">
              <table id="datatable-buttons" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Student ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Total Documents</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($students as $item)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $item->student->studentID }}</td>
                      <td>{{ $item->student->firstName }}</td>
                      <td>{{ $item->student->lastName }}</td>
                      <td>{{ $item->student->email }}</td>
                      <td>{{ $item->student->phone }}</td>
                      <td><span class="label label-success" id="doc_count_{{ $item->student->studentID }}">{{ $item->doc_count->count() }}</span></td>
                      <td>
                        <a href="{{ route('student.document.list', $item->student->studentID) }}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="view-documents"><i
                            class="fa fa-search" aria-hidden="true"></i></a>
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
      <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="myLargeModalLabel">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="clearfix"></div>
            <!-- row start -->
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Documents</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <form method="POST" enctype="multipart/form-data" id="document_store_form">
                      <input type="hidden" id="form_csrf" value="{{ csrf_token() }}">
                      <div class="form-group">
                        <label>Student: </label>
                        <select name="studentID" class="form-control select2">
                          <option></option>
                          @foreach ($all_student as $student)
                            <option value="{{ $student->studentID }}">{{ $student->studentID . ' - ' . $student->firstName . ' - ' . $student->lastName }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Title: </label>
                        <input type="text" class="form-control" name="title" />
                      </div>
                      <div class="form-group">
                        <label>File: </label>
                        <input type="file" class="form-control" name="file" />
                      </div>
                      <div class="form-group">
                        <button class="btn btn-success btn-md pull-right"><span id="loading_icon" style="display: none"><i class="fa fa-spinner rotate-center" aria-hidden="true"></i></span>
                          submit</button>
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
      <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

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
      <script>
        $(document).ready(function() {
          $('.select2').select2({
            placeholder: 'select student..',
            allowClear: true,
            dropdownParent: $('#myLargeModalLabel')
          });
        });
      </script>
      <!-- /validator -->
      <script>
        $("#document_store_form").submit(function(e) {
          e.preventDefault();
          $("#loading_icon").css('display', 'block');
          let url = "{{ route('student.document.store') }}";
          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $("#form_csrf").val(),
            }
          });
          $.ajax({
            type: "POST",
            url: url,
            data: new FormData(this),
            cache: false,
            contentType: false,
            processData: false,
            dataType: "html",
            success: function(response) {
              $("input[name='title']").val('');
              $("input[name='file']").val('');
              let td_id = "doc_count_" + $("select[name='studentID']").val();
              $("#document_content").empty();
              $("#document_content").html(response);
              $("#loading_icon").css('display', 'none');
              toastr.success('File stored successfully');
            },
            error: function(error) {
              toastr.error('Opps! Something is wrong.')
            }
          });
        });
      </script>
    @endsection

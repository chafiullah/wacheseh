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
              <h4 class="text-success">How does this work?</h4>
              <ol>
                <li>These are pure subjects that you assign in the system, later these subjects are assigned in course groups, program outlines and grade books, etc.</li>
                <li class="text-info">The course names are just displaying names in the report card or transcript. You can update it if you really need to, but changing the name will reflect everywhere. What does that mean? Let's say for 10 years you are using 'Mathematics' but on the eleventh year you decided the name to be 'Advanced Mathematics' and you updated it. Magic! it gets updated from everywhere. Do you really want this? I guess not! So, you should create another course name: Advance Mathematics and put it to the outline and upload grades for that new course not the old Mathematics, this is how you preserve both.</li>
                <li class="text-danger">If you delete one course from here: it gets deleted from the groups, course outlines, grade books and student grades. It will be a big problem, so whatever you do here be very specific.</li>
              </ol>
              <div class="clearfix"></div>
              @permission('add-subject')
                <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target=".bd-example-modal-lg" style="margin-top: 15px">+ Add Subjects</button>
              @endpermission
            </div>
            <div class="x_content">
              <table id="datatable-buttons" class="table table-striped table-bordered" style="font-size: 14px">
                <thead>
                  <th>Database ID</th>
                  <th>Subject Name</th>
                  <th>Coefficient</th>
                  <th>Action</th>
                </thead>
                <tbody>

                  @foreach ($courses as $course)
                    <tr>
                      <td>{{ $course->id }}</td>
                      <td>{{ $course->name }}</td>
                      <td>{{ $course->coefficient }}</td>
                      <td>
                        @permission('edit-subject')
                          <a href="{{ route('course.edit', $course->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit    "></i></a>
                        @endpermission

                        @permission('delete-subject')
                          <a href="{{ route('course.destroy', $course->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to remove this item?')"><i
                              class="fas fa-trash    "></i></a>
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
                    <form action="{{ route('course.store') }}" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="form-row">
                        <div class="col-md-6">
                          <label for="">Subject Name:</label>
                          <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                          <label for="">Coefficient:</label>
                          <input type="number" name="coefficient" min="1" value="1" class="form-control" required>
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
    <script>
      $(document).ready(function() {
        $(".select2").select2({
          placeholder: "select class.....",
          allowClear: true,
          dropdownParent: $(".bd-example-modal-lg")
        });
      });
    </script>
  @endsection

@extends('layouts.master')

@section('title', 'Exams')

@section('extrastyle')
<link href="{{ URL::asset('assets/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/css/sweetalert.css')}}" rel="stylesheet">
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
                          <h2>
                            Exam Name: {{ $exam->examName }} <br> <br>
                            Database ID: {{ $exam->id }}
                            <br>
                          </h2>
                          <form action="{{ route('attempted.students.import') }}" method="post" enctype="multipart/form-data">
                          @csrf
                            <div class="form-row">
                              <div class="form-group col-md-12">
                                <h4>Download the format <a href="{{ asset('public/ExcelFormats/ExamAttempted.xlsx') }}" download><b><u>here</u></b></a></h4> 
                                <label for="">Upload Excel File: </label>
                                <input type="file" class="form-control" name="file" required>
                              </div>
                              <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-success btn-md pull-right"><i class="fa fa-upload" aria-hidden="true"></i> upload</button>
                              </div>
                            </div>
                          </form>
                            <div class="clearfix"></div>
                            @permission('can-assign-exams')
                            <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target=".bd-example-modal-lg" style="margin-top: 15px">+ add student one-by-one</button>
                            @endpermission
                        </div>
                        <div class="x_content">
                            <table id="datatable-buttons" class="table table-striped table-bordered">
                                <thead>
                                <th>#</th>
                                <th>Exam Name</th>
                                <th>Student First Name</th>
                                <th>Student Last Name</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Action</th>
                                </thead>
                                <tbody>
                                    @foreach ($examStudents as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $exam->examName }}</td>
                                            <td>{{ $item->student->firstName }}</td>
                                            <td>{{ $item->student->lastName }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->date)->format('m/d/Y') }}</td>
                                            @if ($item->status == 1)
                                                <td class="text-success">Completed</td>
                                            @else
                                                <td class="text-danger">Incompleted</td>
                                            @endif
                                            <td>
                                              @permission('can-remove-students-exams')
                                                <a href="{{ route('attempted.students.destroy', $item->id) }}" class="btn btn-danger btn-md" onclick="return confirm('Are you sure to remove this student from the list?')"><i class="fas fa-trash    "></i></a>
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
                    <div class="x_title">
                        <h2>Exam: {{ $exam->examName }}</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <form action="{{ route('attempted.students.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <label for="">Exam Name:</label>
                              <input type="text" class="form-control" value="{{ $exam->examName }}">
                              <input type="hidden" class="form-control" name="examID" value="{{ $exam->id }}">
                            </div>

                            <div class="form-group col-md-12">
                                <label for="">Student:</label>
                                <select name="studentIDs[]" class="form-control select2" multiple>
                                    <option></option>
                                    @foreach ($students as $student)
                                        <option value="{{ $student->studentID }}">{{ $student->studentID.' - '.$student->firstName.' '.$student->lastName }}</option>
                                    @endforeach
                                </select> 
                            </div>

                            <div class="form-group col-md-12">
                                <label for="">Date:</label>
                                <input type="date" name="date" class="form-control" required>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="">Status:</label>
                                <select name="status" class="form-control">
                                    <option value="1">Completed</option>
                                    <option value="2">Incomplete</option>
                                </select>
                            </div>
                            
                            <div class="form-group col-md-12">
                              <button type="submit" class="btn btn-success btn-md pull-right">submit</button>
                            </div>
                          </div>
                        </form>
                        <div class="clearfix"></div>
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
<script src="{{ URL::asset('assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/dataTables.buttons.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/buttons.bootstrap.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/buttons.flash.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/buttons.html5.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/buttons.print.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/jszip.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/pdfmake.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/vfs_fonts.js')}}"></script>
<script src="{{ URL::asset('assets/js/sweetalert.min.js')}}"></script>

   <script>

     $(document).ready(function() {

     //datatables code
     var handleDataTableButtons = function() {
       if ($("#datatable-buttons").length) {
         $("#datatable-buttons").DataTable({
          "pageLength": 20,
           responsive: true,
           ordering: true,
           dom: "Bfrtip",
           buttons: [
             {
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
    $(document).ready(function () {
      $('.select2').select2({
        placeholder: 'select students..',
        allowClear: true,
        dropdownParent: $(".bd-example-modal-lg")
      });
    });
  </script>
   <!-- /validator -->
@endsection

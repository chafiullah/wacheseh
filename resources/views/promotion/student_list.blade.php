@extends('layouts.master')
@section('extrastyle')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
                    <h4 class="text-info text-center">List of students from academic year: <b>{{\App\AcademicYear::where('academic_year',$request->input('academic_year'))->first()->alias}}</b> and class: <b>{{App\Department::find($request->input('class'))->name}}</b></h4>
                    <div class="x_panel">
                        <div class="x_content">
                           <table class="table" id="datatable-buttons">
                               <thead>
                               <tr>
                                   <th>Student ID</th>
                                   <th>Name</th>
                                   <th>Course Outline</th>
                                   <th>Promoted On</th>
                                   <th>Action</th>
                               </tr>
                               </thead>
                               <tbody>
                               @foreach($students as $student)
                                   <tr>
                                       <td>{{$student->student->student_id}}</td>
                                       <td>{{$student->student->name}}</td>
                                       <td>{{$student->outline->name}}</td>
                                       <td>{{$student->created_at}}</td>
                                       <td>
                                           <a href="{{route('studentinfo.list.byAcademicYear.destroy',$student->id)}}" class="btn btn-danger btn-sm" onclick="return confirm('Removing data from this list is not recommended at all! This data is linked to the grade book, payment and overall performance of the student within the system. In-accurate action performed here in this section may bring severe results in future. Are you sure to continue?')">remove</a>
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
        </div>
    </div>
    <!-- /page content -->
@endsection
@section('extrascript')
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js
  "></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap.min.js
  "></script>
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
                        dom: "Bfrtip",
                        buttons: [{
                            extend: "excel",
                            className: "btn-success btn-sm"
                        }, ],
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
@endsection


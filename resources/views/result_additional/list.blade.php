@extends('layouts.master')
@section('title','additional_data')
@section('extrastyle')
    <link href="{{ URL::asset('assets/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
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
                            <h4>Generated Data of: {{$additionalData->first()->class->name}}/{{$additionalData->first()->semester}}</h4>
                            <h5 class="text-info">What else can I do here?</h5>
                            <ul>
                                <li>From here you can remove any mistake you made before.</li>
                                <li>If you are here to get the format for bulk upload then click on the **Excel** button and download the .xlsx file.</li>
                                <li>Later go the **Student Module > Promote Student** and set the academic year and class. Generate the list and download the excel file.</li>
                                <li>Copy the student_database_ids that you need and leave the rest because the name is irrelevant.</li>
                                <li class="text-danger">DO NOT CHANGE ANY HEADER OF THE EXCEL FILE</li>
                                <li>Once you have the .xlsx file ready go back to the Add Additional Data and upload it in the import section.</li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_panel table-responsive">
                            <table class="table table-striped" id="datatable-buttons">
                                <thead>
                                    <tr>
                                        <th>student_id</th>
                                        <th>class_id</th>
                                        <th>semester</th>
                                        <th>Student Name</th>
                                        <th>un_absent</th>
                                        <th>late</th>
                                        <th>warning</th>
                                        <th>reprimand</th>
                                        <th>suspension</th>
                                        <th>class_master</th>
                                        <th>remarks</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($additionalData as $data)
                                        <tr>
                                            <td>{{$data->student->id}}</td>
                                            <td>{{$additionalData->first()->class->id}}</td>
                                            <td>{{$additionalData->first()->semester}}</td>
                                            <td>{{$data->student->name}}</td>
                                            <td>{{$data->un_absent}}</td>
                                            <td>{{$data->late}}</td>
                                            <td>{{$data->warning}}</td>
                                            <td>{{$data->reprimand}}</td>
                                            <td>{{$data->suspension}}</td>
                                            <td>{{$data->class_master}}</td>
                                            <td>{{$data->remarks}}</td>
                                            <td>
                                                <a href="{{route('additional_data.delete',$data->id)}}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to remove the data?')"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="clearfix"></div>
                        </div>
                        <div class="clearfix"></div>
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
                        buttons: [{
                            extend: "excel",
                            className: "btn-sm"
                        }, ],
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
@endsection

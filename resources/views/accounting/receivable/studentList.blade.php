@extends('layouts.master')

@section('title', 'Payment History')

@section('extrastyle')

@endsection

@section('content')

    <!-- page content -->
    <div class="right_col" role="main">
          <div class="">
          <span class="text-info">Accounts Module v1.1 - Implemented On: 31 Dec 2020</span>

            <div class="clearfix"></div>
            <!-- row start -->
            @if(Request::routeIs('receivable.level'))
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            
                          <h4>Student's Rece - 
                            {{-- department list --}}
                              <a href="{{ route('account.receivable') }}">
                                  <u>{{ $dept = \App\Department::where('short_name',$dept_id)->value('short_name') }}</u> / 
                              </a>
                              {{-- session list --}}
                              <a href="{{ route('receivable.dept', $dept_id) }}">
                                  <u>{{ $semester = \App\Current_Semester_Running::where('title',$semester_id)->value('title') }}</u> / 
                              </a> 
                              {{-- level term list --}}
                              <a href="{{ route('receivable.session', [$dept_id, $semester_id]) }}">
                                <u>{{ $level_term }}</u> / 
                              </a>
                          </h4>
                            
                          <h4 class="text-primary">Total Receivable: {{ count($reg_students) }}</h4>
                            <div class="clearfix"></div>
                            <!--<button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target=".bd-example-modal-lg" style="margin-top: 15px">+ Add Courses</button>-->
                        </div>
                        <div class="row">
                            
                            <table id="datatable-buttons" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                    
                                    <th>Student ID</th>
                                    <th>Full Name</th>
                                    <th>Level Term(Current)</th>
                                    <th>Semester Fee</th>
                                    <th>Less</th>
                                    <th>Paid</th>
                                    <th>Due</th>
                                    <th>Manage</th>
                                    </tr>
                                </thead>
                                @php 
                                    $total=0;
                                    $less=0;
                                    $paid=0;
                                    $due=0;
                                @endphp
                                <tbody>
                                    @foreach ($reg_students as $item)
                                        <tr>
                                            
                                            <td>{{ $item->student_id }}</td>
                                            <td>{{ $item->Full_Name }}</td>
                                            <td>{{ $item->Current_semester }}</td>
                                            <td>{{ $item->total }}</td>
                                            <td>{{ $item->less }}</td>
                                            <td>{{ $item->paid }}</td>
                                            <td>{{ $item->due }}</td>
                                            @php
                                            $total+=$item->total;
                                            $less+=$item->less;
                                            $paid+=$item->paid;
                                            $due+=$item->due;
                                            @endphp
                                        
                                            <td>
                                                @permission('receivableInvoice-read')
                                                <a href="{{ route('receivable.show',$item->id) }}" class="btn btn-info" > <i class="fas fa-print"></i> Invoice</a>
                                                @endpermission
                                                @permission('receivableReceipt-edit')
                                                <a href="{{ route('ledger.create',['receivable_id'=>$item->id,'student_id'=>$item->student_id ]) }}" class="btn btn-danger" >
                                                     <i class="fas fa-money"></i> Receipt</a>
                                                @endpermission
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                      <td>Total</td>
                                      <td></td>
                                      <td></td>
                                      <td>{{ $total }}</td>
                                      <td>{{ $less }}</td>
                                      <td>{{ $paid }}</td>
                                      <td>{{ $due }}</td>
                                      <td></td>
                                    </tr>
                                    
                                </tbody>
                                
                            </table>
                        </div>
                    </div>
                <!-- row end -->
                </div>
            </div>
            @endif
            
            <!-- for all receivable-->
            
            @if(Request::routeIs('all.receivable'))
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
 
                          <h4 class="text-primary">Total Receivable: {{ count($reg_students) }}</h4>
                            <div class="clearfix"></div>
                            <!--<button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target=".bd-example-modal-lg" style="margin-top: 15px">+ Add Courses</button>-->
                        </div>
                        <div class="row">
                            
                            <table id="datatable-buttons" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                    
                                    <th>Student ID</th>
                                    <th>Full Name</th>
                                    <th>Level Term(Current)</th>
                                    <th>Semester Fee</th>
                                    <th>Less</th>
                                    <th>Paid</th>
                                    <th>Due</th>
                                    <th>Manage</th>
                                    </tr>
                                </thead>
                                @php 
                                    $total=0;
                                    $less=0;
                                    $paid=0;
                                    $due=0;
                                @endphp
                                <tbody>
                                    @foreach ($reg_students as $item)
                                        <tr>
                                            
                                            <td>{{ $item->student_id }}</td>
                                            <td>{{ $item->Full_Name }}</td>
                                            <td>{{ $item->Current_semester }}</td>
                                            <td>{{ $item->total }}</td>
                                            <td>{{ $item->less }}</td>
                                            <td>{{ $item->paid }}</td>
                                            <td>{{ $item->due }}</td>
                                            @php
                                            $total+=$item->total;
                                            $less+=$item->less;
                                            $paid+=$item->paid;
                                            $due+=$item->due;
                                            @endphp
                                        
                                            <td>
                                                @permission('receivableInvoice-read')
                                                <a href="{{ route('receivable.show',$item->id) }}" class="btn btn-info" > <i class="fas fa-print"></i> Invoice</a>
                                                @endpermission
                                                @permission('receivableReceipt-edit')
                                                <a href="{{ route('ledger.create',['receivable_id'=>$item->id,'student_id'=>$item->student_id ]) }}" class="btn btn-danger" >
                                                     <i class="fas fa-money"></i> Receipt</a>
                                                @endpermission
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                      <td>Total</td>
                                      <td></td>
                                      <td></td>
                                      <td>{{ $total }}</td>
                                      <td>{{ $less }}</td>
                                      <td>{{ $paid }}</td>
                                      <td>{{ $due }}</td>
                                      <td></td>
                                    </tr>
                                    
                                </tbody>
                                
                            </table>
                        </div>
                    </div>
                <!-- row end -->
                </div>
            </div>
            @endif
        <!-- /page content -->
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
          "pageLength": 50,
           responsive: true,
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
   <!-- /validator -->
   <script>
    $(document).ready(function() {
        $('.select2').select2({
          dropdownParent: $(".bd-example-modal-lg"),
          placeholder: "Select Courses",
          allowClear: true
        });
    });
   </script>
@endsection

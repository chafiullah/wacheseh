@extends('layouts.master')

@section('title', 'Student | Ledger')

@section('extrastyle')
<link href="{{ URL::asset('assets/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/css/select2.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/css/sweetalert.css')}}" rel="stylesheet">
@endsection

@section('content')

    <!-- page content -->
    <div class="right_col" role="main">
          <div class="">
          <span class="text-info">Accounts Module v1.1 - Implemented On: 31 Dec 2020</span>

            <div class="clearfix"></div>
            <!-- row start -->
            <div class="row">
                <div class="x_content">
                    {{-- <div class="x_panel">
                        <form class="form-inline" action="#">
                            <div class="form-group">
                              <label class="sr-only" for="email">Student ID:</label>
                              <select class="form-control student" id="email" name="student_id">
                                  <option></option>
                                  @foreach ($students as $item)
                                      <option value="{{ $item->Registration_Number }}">{{ $item->Registration_Number }} - ({{ $item->Full_Name }})</option>
                                  @endforeach
                                  
                              </select>
                            </div>
                            <div class="form-group">
                              <label  for="pwd">To:</label>
                              <input type="date" class="form-control"  name="pwd">
                            </div>

                            <div class="form-group">
                                <label  for="pwd">From:</label>
                                <input type="date" class="form-control"  name="pwd">
                              </div>
                              
                                <button type="submit" style="margin-top:5px;" class="btn btn-default">Submit</button>
                              
                          </form>
                    </div> --}}
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h3>Student ID: {{ $student->Registration_Number }}</h3>
                            <h3 class="text-right">Name: {{ $student->Full_Name }}</h3>
                            <h3>Department: {{ $student->Program }}</h3>
                            <h3 class="text-right">Level Term(Current): {{ $student->Current_semester }}</h3>
                            <h3 class="text-center">Student Ledger(All)</h3>
                        </div>
                        <div class="x_content">
                            <div class="col-md-12">
                               
                            <table  class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                    
                                    <th>Date</th>
                                    <th>Particulars</th>

                                    <th>Debit(Dr)</th>
                                    <th>Credit(Cr)</th>
                                    <th>Closing Balance</th>
                                    <th>Remarks</th>
                                    <th>Action</th>
                                    
                                    </tr>
                                </thead>

                                
                                <tbody>
                                   @php
                                       $total_Dr=0;
                                       $total_Cr=0;
                                   @endphp
                                    @foreach ($particulars as $fee)
                                        
                                            <tr>
                                                
                                                <td>{{ $fee->date }}</td>
                                                <td>@if ($fee->is_semester=='1')
                                                    <a href="{{ route('student.journal',$fee->id) }}">{{ $fee->particular }}</a>
                                                    @else
                                                        {{ $fee->particular }}
                                                    @endif
                                                </td>
                                            @if ($fee->account_type=='Dr')
                                                <td>{{ $fee->amount }}</td>
                                                <td></td>
                                                <td></td>
                                                <td>{{$fee->remarks}}</td>
                                                @php
                                                    $total_Dr+=$fee->amount;
                                                @endphp
                                            @endif
                                            @if ($fee->account_type=='Cr')
                                                <td></td>
                                                <td>{{$Cr= $fee->amount }}</td>
                                                <td></td>
                                                <td>{{$fee->remarks}}</td>
                                                @php
                                                $total_Cr+=$fee->amount;
                                                @endphp
                                            @endif
                                                <td>
                                                @permission('ledger-edit')
                                                 <a class="btn btn-info" href="{{route('ledger.edit',$fee->id)}}"> <i class="fa fa-edit"></i> Edit</a>||
                                                @endpermission
                                                @permission('ledger-delete')
                                                <a class="btn btn-danger" href="{{ route('ledger.delete',$fee->id) }}" 
                                                onclick="return confirm('Are you sure want to delete this leger?');">
                                                    <i class="fa fa-remove"></i> Delete</a>
                                                @endpermission   
                                                </td>
                                               
                                            </tr>
                                            
                                    @endforeach
                                        <tr>
                                            <td colspan="2">a. Total </td>
                                            <td class="text-info"> {{ $total_Dr }}</td>
                                            <td class="text-success">{{ $total_Cr }}</td>
                                            <td class="text-danger">{{ $total_Dr-$total_Cr }}</td>
                                        </tr>

                                </tbody>
                                
                            </table>
                            </div>

                        </div>
                    </div>
                <!-- row end -->
                </div>
            </div>
        <!-- /page content -->
    </div>
    <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Semester Fee Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <table  class="table table-striped table-bordered">
                <thead>
                    <tr>
                    
                    <th>Fee Name</th>
                    <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($feeDetails as $item)
                    
                        <tr>
                            
                            <td>{{ $item->feelists->fee_name }}</td>
                          
                            <td>{{ $item->feelists->amount }}</td>
                            
                        </tr>
                    
                        
                    @endforeach
                    
                    <tr>
                        <td>Total Credit ({{ $totalCredit }})</td>
                        <td></td>
                    </tr>
                    
                    
                </tbody>
                
            </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
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
<script src="{{ URL::asset('assets/js/select2.full.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/sweetalert.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/daterangepicker.js')}}"></script>
   <script>

     $(document).ready(function() {
        $(".student").select2({
                placeholder: "Select Student ID",
                allowClear: true
            });
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
   
@endsection

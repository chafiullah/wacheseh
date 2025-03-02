@extends('layouts.master')

@section('title', 'Student | Invoice')

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
          <span class="text-info">Accounts Module v1.1 - Implemented On: 31 Dec 2020</span>

            <div class="clearfix"></div>
            <!-- row start -->
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h3>Student ID: {{ $student->Registration_Number }}</h3>
                            <h3 class="text-right">Name: {{ $student->Full_Name }}</h3>
                            <h3>Department: {{ $student->Program }}</h3>
                            <h3 class="text-right">Level Term(Current): {{ $student->Current_semester }}</h3>
                            <h3 class="text-center">Student Invoice</h3>
                        </div>
                        <div class="x_content">
                            <div class="col-md-5">
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <table  class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                    
                                    <th>Student ID</th>
                                    <th>Particulars</th>

                                    <th>Amount</th>
                                    <th>Type</th>
                                    <th>Taka</th>
                                    </tr>
                                </thead>

                                
                                <tbody>
                                    @php
                                        $fee_total=0;
                                        $less_total=0;
                                        $paid_total=0;
                                    @endphp
                                    <tr>
                                        <td><b>Fee Details:</b></td>
                                    </tr>
                                    @foreach ($particulars_fee as $fee)
                                        
                                            <tr>
                                                
                                                <td>{{ $fee->date }}</td>
                                                <td>{{ $fee->particular }} </td>
                                                
                                            
                                                <td>{{ $fee->amount }}</td>
                                                <td>{{ $fee->account_type }} </td>
                                                @php
                                                    $fee_total+=$fee->amount;
                                                @endphp
                                                @if($fee->is_semester==1)
                                                <td>
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                                        Fee Detail
                                                    </button>
                                                </td>
                                                @endif
                                            </tr>
                                            
                                    @endforeach
                                        <tr>
                                            <td></td>
                                            <td colspan="3">a. Total</td>
                                            <td >{{ $fee_total }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Less:</b></td>
                                        </tr>
                                        <tr>
                                    @foreach ($particulars_less as $less)    
                                            <td>{{ $less->date }}</td>
                                            <td>{{ $less->particular }}</td>
                                            @php
                                            $less_total+=$less->amount;
                                            @endphp
                                            <td>{{ $less->amount }}</td>
                                            <td>{{ $less->account_type }}</td>
                                            <td>
                                                <a href="{{ route('ledger.delete',$less->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?');"> <i class="fas fa-trash"></i> Delete</a>
                                            </td>
                                        </tr>
                                        
                                     @endforeach
                                            <tr>
                                                <td></td>
                                                <td colspan="3">b. Total</td>
                                                <td>{{ $less_total }}</td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td colspan="3">c. Payable for this semester(a-b)</td>
                                                <td>{{ $less_amount=$fee_total-$less_total }}</td>
                                            </tr>
                                     
                                            <tr>
                                                <td><b>Paid Amount:</b></td>
                                            </tr>
                                @foreach ($particulars_paid as $paid)  
                                            <tr>
                                            
                                                <td>{{ $paid->date }}</td>
                                                <td>{{ $paid->particular }}</td>
                                                @php
                                                $paid_total+=$paid->amount;
                                                @endphp
                                                <td>{{ $paid->amount }}</td>
                                                <td>{{ $paid->account_type }}</td>
                                                <td>
                                                    <!--<a href="{{ route('ledger.delete',$paid->id) }}" class="btn btn-danger btn-sm"-->
                                                    <!--onclick="return confirm('Are you sure you want to delete this item?');"> -->
                                                    <!--<i class="fas fa-trash"></i> Delete</a>-->
                                                </td>
                                            </tr>
                                            
                                           
                                    @endforeach
                                    <tr>
                                        <td></td>
                                        <td colspan="3">d.Total</td>
                                        <td>{{ $paid_total }}</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td colspan="3">e.This Semester Dues</td>
                                        <td>{{ $less_amount-$paid_total }}</td>
                                    </tr>
                                            
                                    
                                </tbody>
                                
                            </table>
                            </div>
                            <div class="col-md-7">
                                <!--<div class="row">-->
                                <!--    <div class="col-md-12 ">-->
                                <!--        <form class="form-inline" action="{{ route('ledger.store') }}" method="post">-->
                                <!--            @csrf-->
                                <!--        <table>-->
                                <!--                <tr>-->
                                <!--                    <td>-->
                                <!--                        <input type="date" class="form-control" id="date" name="date" value="{{$today->format('Y-m-d')}}"  required="required" />-->
                                <!--                    </td>-->

                                <!--                    <td>-->
                                                        
                                <!--                        <select class="form-control select2" name="fee_id" >-->
                                <!--                            <option></option>-->
                                <!--                            @foreach ($fees as $item)-->
                                <!--                                <option value="{{ $item->id }}">{{ $item->fee_name }}</option>-->
                                <!--                            @endforeach-->
                                          
                                <!--                          </select>-->
                                <!--                    </td>-->
                                                    
                                <!--                    <td>-->
                                <!--                        <input type="text" class="form-control" name="amount" placeholder="Amount">-->

                                <!--                        <input type="hidden"  value="{{ $receivable->student_id }}" name="student_id">-->
                                <!--                        <input type="hidden" value="{{ $receivable->id }}"  name="receivable_id"> -->
                                <!--                    </td>-->
                                                    
                                                    
                                <!--                    <td>&nbsp;<button class="btn btn-success" type="submit">+Add</button></td>-->
                                <!--                </tr>-->
                                <!--        </table>-->
                                <!--        </form>-->
                                <!--    </div>-->
                                <!--</div>-->
                                <br>
                                <br>
                                <br>
                                <div class="row">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Due Details(Semester)</th>
                                                <th>Taka</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @isset($previous_dues)
                                                @foreach ($previous_dues as $due)
                                                    <tr>
                                                        <td>{{ $due->particular }}</td>
                                                        <td>{{ $due->amount }}</td>
                                                        @php
                                                        $pre_balance+=$due->amount;
                                                        @endphp
                                                    </tr>

                                                @endforeach   
                                            @endisset
                                            

                                            @foreach ($dues as $item)
                                            <tr>
                                                <td>{{ $item->semester }}</td>
                                                <td>{{ $item->due }}</td>
                                                @php
                                                 $due_balance+=$item->due;
                                                @endphp
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td>Total Dues</td>
                                                <td>{{ $pre_balance+$due_balance }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                        <!-- Student Ledger-->
                            <div class="x_content">
                                <a href="{{ route('student.ledger',$student->Registration_Number) }}" class="btn btn-info btn-sm" > <i class="fas fa-eye"></i> Sudent Ledger</a>
                            </div>
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
                    <th>Type</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($feeDetails as $item)
                    
                        <tr>
                            
                            <td>{{ $item->feelists->fee_name }}</td>
                          
                            <td>{{ $item->feelists->amount }}</td>
                            <td>{{ 'Cr' }}</td>
                            
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
<script src="{{ URL::asset('assets/js/sweetalert.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/daterangepicker.js')}}"></script>
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
         
          placeholder: "Select Particular",
          allowClear: true
        });
    });
   </script>
@endsection

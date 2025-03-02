@extends('layouts.master')

@section('title', 'Semester Events')
@section('extrastyle')
<link href="{{ URL::asset('assets/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
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
                    <h2>Semester Events</h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_title text-right">
                    @permission('can-manage-events')
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">+ Add New</button>
                    @endpermission

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    @if (Session::has('msg'))
                        <div class="alert alert-success">
                            {!! \Session::get('msg') !!}
                        </div>
                    @endif
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Title</th>
                          <th>Starts</th>
                          <th>Ends</th>
                          <th>Remarks</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($events as $item)
                            <tr>
                              <td>{{ $item->type->title }}</td>
                              <td>{{ Carbon\Carbon::parse($item->starts)->format('d M Y') }}</td>
                              <td>{{ Carbon\Carbon::parse($item->ends)->format('d M Y') }}</td>
                              <td>{{ $item->remarks }}</td>
                              <td>
                                @permission('can-manage-events')
                                  <a href="{{ route('semester-event.edit', $item->id) }}" class="btn btn-warning"> <i class="fas fa-edit"></i> edit</a>
                                  <a href="{{ route('semester-event.delete', $item->id) }}" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?');"> <i class="fas fa-trash"></i> delete</a>
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
        </div>
            
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="clearfix"></div>
                    <!-- row start -->
                    <div class="row">
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                          <div class="x_title">
                            <h2>Add Semester Details</h2>
                            <div class="clearfix"></div>
                          </div>
                          <div class="x_content">
                            <form method="POST" action="{{ route('semester-event.store') }}" enctype="multipart/form-data">
                            @csrf
                                <div class="form-group">
                                    <label>Semester Title: </label>
                                    <input class="form-control" name="session_id" value="{{ $session_id }}" readonly>
                                </div>

                                <div class="form-group">
                                  <label>Event: </label>
                                  <select name="type_id" class="form-control" required>
                                    @foreach ($types as $item)
                                        <option value="{{ $item->id }}">{{ $item->title }}</option>
                                    @endforeach
                                  </select>
                                </div>

                                <div class="form-group">
                                    <label>Starts From: </label>
                                    <input type="date" class="form-control" name="starts" required/>
                                </div>

                                <div class="form-group">
                                  <label>Ends at: </label>
                                  <input type="date" class="form-control" name="ends" required/>
                                </div>

                                <div class="form-group">
                                    <label>Remarks: </label>
                                    <textarea name="remarks" class="form-control"></textarea>
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
   <script>

     $(document).ready(function() {
     //datatables code
     var handleDataTableButtons = function() {
       if ($("#datatable-buttons").length) {
         $("#datatable-buttons").DataTable({
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

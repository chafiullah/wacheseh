@extends('layouts.master')

@section('title', 'Audit Logs')
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
                    <h2>Audit Details</h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_title text-right">
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content table-responsive">
                    @if (Session::has('msg'))
                        <div class="alert alert-success">
                            {!! \Session::get('msg') !!}
                        </div>
                    @endif
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>Action</th>
                          <th>Model</th>
                          <th>Old</th>
                          <th>New</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($audits as $audit)
                            <tr>
                              <td>{{ $audit->name }}</td>
                              <td>{{ $audit->event }}</td>
                              <td>{{ $audit->auditable_type }}</td>
                              <td>{{ $audit->old_values }}</td>
                              <td>{{ $audit->new_values }}</td>
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
           ordering: false,
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

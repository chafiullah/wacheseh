@extends('layouts.master')

@section('title', 'Students Result')
@section('extrastyle')
<link href="{{ URL::asset('assets/css/select2.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/css/switchery.min.css')}}" rel="stylesheet">
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
                     <div class="row">
                        <div class="col-md-12">
                           <div class="table-responsive">
                              <table id="datatable-buttons" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                           <th>Student ID</th>
                                           <th>Name</th>
                                           <th>CGPA</th>
                                           <th>Earned Credit</th>
                                        </tr>
                                     </thead>
                                     <tbody>
                                        @foreach($results as $r)
                                            <tr>
                                                <td>{{$r->student_id}}</td>
                                                <td>{{$r->student->firstName." ".$r->student->middleName." ".$r->student->lastName}}</td>
                                                <td>{{$r->cgpa}}</td>
                                                <td>{{$r->credit}}</td>
                                            </tr>
                                        @endforeach
                                     </tbody>
                                    </table>
                                 </div>
                              </div>
                           </div>


                     </div>
                    
                  </div>
                  <!-- row end -->



               </div>
            </div>
         </div>
            <!-- /page content -->
            @endsection
            @section('extrascript')
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
            <script src="{{ URL::asset('assets/js/validator.min.js')}}"></script>
            <script src="{{ URL::asset('assets/js/select2.full.min.js')}}"></script>
            <script src="{{ URL::asset('assets/js/switchery.min.js')}}"></script>
            <script src="{{ URL::asset('assets/js/validator.min.js')}}"></script>
            <script src="{{ URL::asset('assets/js/moment.min.js')}}"></script>
            <script src="{{ URL::asset('assets/js/daterangepicker.js')}}"></script>
            <!-- validator -->
            <script>
            $(document).ready(function() {
             
               // validate a field on "blur" event, a 'select' on 'change' event & a '.reuired' classed multifield on 'keyup':
               $('form')
               .on('blur', 'input[required], input.optional, select.required', validator.checkField)
               .on('change', 'select.required', validator.checkField)
               .on('keypress', 'input[required][pattern]', validator.keypress);

               $('form').submit(function(e) {
                  e.preventDefault();
                  var submit = true;

                  // evaluate the form using generic validaing
                  if (!validator.checkAll($(this))) {
                     submit = false;
                  }

                  if (submit)
                  this.submit();

                  return false;
               });

               <!-- /validator -->
               $(".department").select2({
                  placeholder: "Pick a department",
                  allowClear: true
               });
               $(".course").select2({
                  placeholder: "Pick a course",
                  allowClear: true
               });
               $(".semester").select2({
                  placeholder: "Pick a semester",
                  allowClear: true
               });
               $(".session").select2({
                  placeholder: "Pick a session",
                  allowClear: true
               });


               //make all checkbox checked
               $('.allCheck').on('change',function() {
                  $('.tb-switch').trigger('click');
               });
               //experimental code



            });

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
            @endsection

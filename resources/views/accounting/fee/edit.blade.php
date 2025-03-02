@extends('layouts.master')

@section('title', 'Fee | Edit')

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
                    <h2>Fee <small> Fee  basic information.</small></h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <form action="{{ route('fee.update',$fee->id) }}" method="post">
                      @csrf
                      @method("PATCH")
                        <div class="form-row">
                          <div class="form-group col-md-6">
                            <label for="">Fee Title: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="feeTitle"  value="{{ $fee->feeTitle }}" required>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="">Minimum Payable Amount: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="payableAmount"  value="{{ $fee->payableAmount }}" required>
                          </div>
                        </div>
                        <div class="form-group col-md-12">
                          <button class="btn btn-success btn-md pull-right">submit</button>
                        </div>
                      </form>
                  </div>
                </div>
              <!-- row end -->
              <div class="clearfix"></div>

          </div>
        </div>
        <!-- /page content -->
@endsection
@section('extrascript')
<script src="{{ URL::asset('assets/js/validator.min.js')}}"></script>
<!-- validator -->
   <script>
     // initialize the validator function
     validator.message.date = 'not a real date';

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
   </script>
   <!-- /validator -->
@endsection

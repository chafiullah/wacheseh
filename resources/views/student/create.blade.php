@extends('layouts.master')

@section('extrastyle')
  <link href="{{ URL::asset('assets/css/select2.min.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('assets/css/green.css') }}" rel="stylesheet">
@endsection

@section('content')

  <!-- page content -->
  <div class="right_col" role="main">
    <div class="">
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">

          @if ($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <div class="x_panel">
            <div class="x_title">
              <h2>Student Admission<small class="text-danger"> * Feilds are required.</small></h2>
              <div class="clearfix"></div>
            </div>

            <div class="x_content">
              <form method="post" action="{{ route('studentInfo.store') }}" enctype="multipart/form-data">
                @csrf
                <!--academic information-->
                <div class="form-row">
                  <!--title-->
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h3 class="text-info text-center">Academic Information</h3>
                  </div>
                  <!--enrolled semester-->
                  <div class="form-group col-md-4 col-lg-4 col-sm-12 col-xs-12">
                    <label for="studentSession">Enrollment Session: <span class="text-danger">*</span></label>
                    <input type="date" name="admission_date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="form-control has-feedback-left" required>
                    <i class="fa fa-calendar form-control-feedback left" aria-hidden="true"></i>
                  </div>
                  <div class="form-group col-md-4 col-lg-4 col-sm-6 col-xs-6">
                    <label for="program_id">Class: <span class="text-danger">*</span></label>
                    <select name="class" class="form-control has-feedback-left" required>
                      @foreach ($classes as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                      @endforeach
                    </select>
                    <i class="fa fa-info form-control-feedback left" aria-hidden="true"></i>
                  </div>
                  {{-- Series --}}
                  <div class="form-group col-md-4 col-lg-4 col-sm-12 col-xs-12">
                    <label for="student_series">Select a series: <span class="text-danger">*</span></label>
                    <select name="student_series" class="form-control has-feedback-left" required>
                      @foreach (config('constant.series') as $item)
                        <option value="{{ $item }}">{{ $item }}</option>
                      @endforeach
                    </select>
                    <i class="fa fa-info form-control-feedback left" aria-hidden="true"></i>
                  </div>
                  <!--program-->
                  {{-- Academic Status --}}
                  <div class="form-group col-md-6 col-lg-6 col-sm-12 col-xs-12">
                    <label for="program_id">Academic Status: <span class="text-danger">*</span></label>
                    <select name="status" class="form-control has-feedback-left" required>
                      <option value="{{ config('constant.active') }}">{{ config('constant.active') }}</option>
                      <option value="{{ config('constant.withdrawn') }}">{{ config('constant.withdrawn') }}</option>
                      <option value="{{ config('constant.expelled') }}">{{ config('constant.expelled') }}</option>
                      <option value="{{ config('constant.alumni') }}">{{ config('constant.alumni') }}</option>
                    </select>
                    <i class="fa fa-info form-control-feedback left" aria-hidden="true"></i>
                  </div>
                  {{-- if student is a repeater --}}
                  <div class="form-group col-md-6 col-lg-6 col-sm-12 col-xs-12">
                    <label for="program_id">Is Repeater: <span class="text-danger">*</span></label>
                    <select name="repeater" class="form-control has-feedback-left" required>
                      <option value="no">No</option>
                      <option value="yes">Yes</option>
                    </select>
                    <i class="fa fa-info form-control-feedback left" aria-hidden="true"></i>
                  </div>
                </div>

                <!--student information-->
                <div class="form-row">
                  <!--title-->
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h3 class="text-info text-center" style="margin-top:4%">Student & Legal Guidance Information </h3>
                  </div>

                  <!--full name-->
                  <div class="form-group col-md-6 col-sm-12 col-xs-12">
                    <label for="firstName">Name: <span class="text-danger">*</span></label>
                    <input type="text" id="name" value="{{ old('name') }}" class="form-control has-feedback-left" name="name" required="required" />
                    <i class="fa fa-user form-control-feedback left" aria-hidden="true"></i>
                  </div>

                  <!--gender-->
                  <div class="form-group col-md-6 col-sm-12 col-xs-12">
                    <label for="gender">Gender:</label>
                    <select class="form-control has-feedback-left" name="gender">
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                    </select>
                    <i class="fa fa-male form-control-feedback left" aria-hidden="true"></i>
                  </div>

                  <!--Date of Birth-->
                  <div class="form-group col-md-4 col-sm-12 col-xs-12">
                    <label for="dob">Date of birth: <span class="text-danger">*</span></label>
                    <input type="date" name="date_of_birth" id="dob" value="{{ old('dob') }}" class="form-control has-feedback-left" required>
                    <i class="fa fa-calendar form-control-feedback left" aria-hidden="true"></i>
                  </div>
                  <!--email address-->
                  <div class="form-group col-md-4 col-sm-12 col-xs-12">
                    <label for="email ">Email Address:</label>
                    <input type="email" id="email " class="form-control has-feedback-left" name="email" data-parsley-trigger="change" />
                    <i class="fa fa-envelope form-control-feedback left" aria-hidden="true"></i>
                  </div>
                  <!--student mobile number-->
                  <div class="form-group col-md-4 col-sm-12 col-xs-12">
                    <label for="phone">Student Mobile Number:</label>
                    <input type="text" class="form-control has-feedback-left" name="phone" />
                    <i class="fa fa-phone form-control-feedback left" aria-hidden="true"></i>
                  </div>

                  <!--Legal Guidance Information-->

                  <!--full name-->
                  <div class="form-group col-md-4 col-sm-12 col-xs-12">
                    <label for="firstName">Legal Guidance Name: </label>
                    <input type="text" id="legal_guidance" value="{{ old('legal_guidance') }}" class="form-control has-feedback-left" name="legal_guidance"/>
                    <i class="fa fa-user form-control-feedback left" aria-hidden="true"></i>
                  </div>

                  <!--email address-->
                  <div class="form-group col-md-4 col-sm-12 col-xs-12">
                    <label for="email ">Legal Guidance Email Address :</label>
                    <input type="email" id="guidance_email " class="form-control has-feedback-left" name="guidance_email" value="{{ old('guidance_email') }}" data-parsley-trigger="change"/>
                    <i class="fa fa-envelope form-control-feedback left" aria-hidden="true"></i>
                  </div>
                  <!--student mobile number-->
                  <div class="form-group col-md-4 col-sm-12 col-xs-12">
                    <label for="phone">Legal Guidance Mobile Number:</label>
                    <input type="text" class="form-control has-feedback-left" name="guidance_phone" value="{{ old('guidance_phone') }}" />
                    <i class="fa fa-phone form-control-feedback left" aria-hidden="true"></i>
                  </div>
                </div>
                <!--geographic information-->
                <div class="form-row">
                  <!--title-->
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h3 class="text-info text-center" style="margin-top:4%">Address Information</h3>
                  </div>
                  <!--Student Region-->
                  <div class="form-group col-md-12 col-lg-12 col-sm-6 col-xs-6">
                    <label for="program_id">Region:</label>
                    <select name="region" class="form-control has-feedback-left">
                      @foreach ($regions as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                      @endforeach
                    </select>
                    <i class="fa fa-info form-control-feedback left" aria-hidden="true"></i>
                  </div>
                  <!--present address-->
                  <div class="form-group col-md-12 col-sm-12 col-xs-12">
                    <label for="address">Address:</label>
                    <textarea id="address" class="form-control has-feedback-left" name="address"></textarea>
                    <i class="fa fa-home form-control-feedback left" aria-hidden="true"></i>
                  </div>

                </div>
                <!--Files-->
                <div class="form-row">
                  <!--title-->
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h3 class="text-info text-center" style="margin-top:4%">File and Image Upload Section</h3>
                  </div>
                  {{-- student Image --}}
                  <div class="form-group col-md-12 col-lg-12 col-sm-6 col-xs-6">
                    <label for="program_id">Student Image:</label>
                    <input type="file" name="image" class="form-control has-feedback-left">
                    <i class="fa fa-info form-control-feedback left" aria-hidden="true"></i>
                  </div>
                  <!--previous record-->
                  <div class="form-group col-md-12 col-lg-12 col-sm-6 col-xs-6">
                    <label for="program_id">Report Card of Previous Academic Year: </label>
                    <input type="file" name="report_card" class="form-control has-feedback-left">
                    <i class="fa fa-info form-control-feedback left" aria-hidden="true"></i>
                  </div>
                  <!--date of birth certificate-->
                  <div class="form-group col-md-12 col-sm-12 col-xs-12">
                    <label for="address">Date of Birth Certificate: </label>
                    <input type="file" name="birth_certificate" class="form-control has-feedback-left">
                    <i class="fa fa-home form-control-feedback left" aria-hidden="true"></i>
                  </div>

                </div>
                {{-- Remarks information --}}
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="">Remarks (if any):</label>
                    <textarea name="remarks" class="form-control" cols="30" rows="10"></textarea>
                  </div>
                </div>
                <!--submission-->
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <button type="submit" class="btn btn-primary btn-lg pull-right">Submit</button>
                  </div>
                </div>
              </form>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /page content -->
@endsection
@section('extrascript')
  <script src="{{ URL::asset('assets/js/select2.full.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/icheck.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/jquery.inputmask.bundle.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/validator.min.js') }}"></script>


  <script>
    $(document).ready(function() {

      $(".select2_single").select2({
        placeholder: "Select a Option",
        allowClear: true
      });
      $(":input").inputmask();

      $(".session").select2({
        placeholder: "Pick a session",
        allowClear: true
      });

      //get subject lists
      $('#division_id').on('change', function() {
        var dept = $('#division_id').val();


        if (!dept) {
          new PNotify({
            title: 'Validation Error!',
            text: 'Please Pic A Division or Write session!',
            type: 'error',
            styling: 'bootstrap3'
          });
        } else {
          //for students
          //populateStudentGrid(dept);


          $.ajax({
            url: '/admin/add/' + dept,
            type: 'get',
            dataType: 'json',
            success: function(data) {

              console.log(data);
              $('#district_id').empty();
              // alert(data.subjects);
              $('#district_id').append('<option >Select a District</option>');
              $.each(data.subjects, function(key, value) {
                //alert('working');
                $('#district_id').append('<option  value="' + value.id + '">' + value.name + '[' + value.bn_name + ']</option>');

              });

              $(".subject").select2({
                placeholder: "Pick a Subject",
                allowClear: true
              });



            },
            error: function(data) {
              var respone = JSON.parse(data.responseText);
              $.each(respone.message, function(key, value) {
                new PNotify({
                  title: 'Error!',
                  text: value,
                  type: 'error',
                  styling: 'bootstrap3'
                });
              });
            }
          });
        }
      });

      $('#district_id').on('change', function() {
        var dept = $('#district_id').val();
        // alert(dept);

        if (!dept) {
          new PNotify({
            title: 'Validation Error!',
            text: 'Please Pic A District or Write session!',
            type: 'error',
            styling: 'bootstrap3'
          });
        } else {
          //for students
          //populateStudentGrid(dept);

          $.ajax({
            url: '/admin2/add/' + dept,
            type: 'get',
            dataType: 'json',
            success: function(data) {

              console.log(data);
              $('#upazila_id').empty();
              // alert(data.subjects);
              $('#upazila_id').append('<option >Select a Upazila</option>');
              $.each(data.subjects, function(key, value) {
                //alert('working');
                $('#upazila_id').append('<option  value="' + value.id + '">' + value.name + '[' + value.bn_name + ']</option>');

              });

              $(".subject").select2({
                placeholder: "Pick a Subject",
                allowClear: true
              });



            },
            error: function(data) {
              var respone = JSON.parse(data.responseText);
              $.each(respone.message, function(key, value) {
                new PNotify({
                  title: 'Error!',
                  text: value,
                  type: 'error',
                  styling: 'bootstrap3'
                });
              });
            }
          });
        }
      });

      $('#upazila_id').on('change', function() {
        var dept = $('#upazila_id').val();
        // alert(dept);

        if (!dept) {
          new PNotify({
            title: 'Validation Error!',
            text: 'Please Pic A Upazilla or Write session!',
            type: 'error',
            styling: 'bootstrap3'
          });
        } else {
          //for students
          //populateStudentGrid(dept);

          $.ajax({
            url: '/admin3/add/' + dept,
            type: 'get',
            dataType: 'json',
            success: function(data) {

              console.log(data);
              $('#union_id').empty();
              // alert(data.subjects);
              $('#union_id').append('<option >Select a Union</option>');
              $.each(data.subjects, function(key, value) {
                //alert('working');
                $('#union_id').append('<option  value="' + value.id + '">' + value.name + '[' + value.bn_name + ']</option>');

              });

              $(".subject").select2({
                placeholder: "Pick a Subject",
                allowClear: true
              });



            },
            error: function(data) {
              var respone = JSON.parse(data.responseText);
              $.each(respone.message, function(key, value) {
                new PNotify({
                  title: 'Error!',
                  text: value,
                  type: 'error',
                  styling: 'bootstrap3'
                });
              });
            }
          });
        }
      });
    });
  </script>
@endsection
@section('extrascript')
  <script src="{{ URL::asset('assets/js/validator.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/jquery.inputmask.bundle.min.js') }}"></script>
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
  <script>
    $(document).ready(function() {

      $("#time").inputmask();
    });
  </script>
  <!-- /validator -->
@endsection

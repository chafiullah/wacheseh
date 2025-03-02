@extends('layouts.master')

@section('title', 'Mark')
@section('extrastyle')
  <link href="{{ URL::asset('assets/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('assets/css/responsive.dataTables.min.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('assets/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('assets/css/select2.min.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('assets/css/sweetalert.css') }}" rel="stylesheet">

@endsection

@section('content')

  <!-- page content -->
  <div class="right_col" role="main">
    <div class="">

      <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_content">
              <form action="{{ route('mark.store') }}" method="post">
                @csrf
                <div class="form-row">
                  <div class="form-group col-md-3 col-sm-12">
                    <label for="">Select Semester: <span class="text-danger">*</span></label>
                    <select name="semester" class="form-control" required>
                      <option value="{{ config('constant.sem1') }}">{{ config('constant.sem1') }}</option>
                      <option value="{{ config('constant.sem2') }}">{{ config('constant.sem2') }}</option>
                      <option value="{{ config('constant.sem3') }}">{{ config('constant.sem3') }}</option>
                    </select>
                  </div>
                  <div class="form-group col-md-3 col-sm-12">
                    <label for="">Academic Year: <span class="text-danger">*</span></label>
                    <select name="academic_year" class="form-control subject" id="academic_year" required>
                      <option></option>
                      @foreach ($academic_years as $year)
                        <option value="{{ $year->academic_year }}" @if(\App\Helper\Helper::getActiveAcademicYear()->academic_year==$year->academic_year )selected @endif>
                          {{ $year->alias }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-md-3 col-sm-12">
                    <label for="">Class: <span class="text-danger">*</span></label>
                    <select name="class_id" class="form-control subject" id="class_id" required>
                      <option></option>
                      @foreach ($classes as $class)
                        <option value="{{ $class->id }}">
                          {{ $class->name }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-md-3 col-sm-12">
                    <label for="">Select Student: <span class="text-danger">*</span></label>
                    <select name="student_id" class="form-control" id="student_list" required>

                    </select>
                    <small class="text-danger" id="waiting_message"></small>
                  </div>
                </div>
                <div class="form-row dataBlock2" style="margin-bottom: 5%">
                  <div class="form-group col-md-12">
                    <label for="">Course:<span class="text-danger">*</span></label>
                    <select name="courses[]" class="form-control subject">
                      <option></option>
                      @foreach ($courses as $item)
                        <option value="{{ $item->id }}">{{ $item->name . ' - cof:' . $item->coefficient }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="">N1 Grade:<span class="text-danger">*</span></label>
                    <input type="number" name="n1_marks[]" class="form-control" onchange="calculate_grades(event)" required>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="">N2 Grade:<span class="text-danger">*</span></label>
                    <input type="number" name="n2_marks[]" value="0" class="form-control" onchange="calculate_grades(event)" required>
                  </div>
                  <div class="form-group col-md-12">
                    <label for="">Signature: <span class="required">*</span></label>
                    <input type="text" class="form-control" name="signatures[]" required>
                  </div>
                  <div class="form-group col-md-12">
                    <br> <br>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <button type="submit" class="btn btn-success pull-right">submit</button>
                    <a class="btn btn-danger pull-right cancel2">cancel-added-block</a>
                    <a href="javascript:void(0)" class="addField2 btn btn-info pull-right"><i class="fas fa-plus-circle    "></i> add another course
                      grade</a>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('extrascript')
  <script src="{{ URL::asset('assets/js/validator.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/jquery.inputmask.bundle.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/select2.full.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/sweetalert.min.js') }}"></script>
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
      $(".subject").select2({
        placeholder: "Select a value",
        allowClear: true
      });
    });
  </script>
  {{-- Listing the students --}}
  <script>
    $(document).ready(function() {
      $("#class_id").on("change", function() {
        $("#waiting_message").empty();
        $("#waiting_message").text("Please wait till the list loads.....");
        var class_id = $("#class_id").val();
        var academic_year = $("#academic_year").val();
        if (academic_year === ''){
          alert('You have to select academic year first!');
          $("#waiting_message").text('Please select both academic year and class');
          $("#class_id").clear();
        }
        var path = "{{ route('get-student.list') }}";
        // console.log(class_id);
        $.ajax({
          type: "get",
          url: "{{ route('get-student.list') }}",
          data: {
            "class_id": class_id,
            "academic_year":academic_year
          },
          dataType: "html",
          success: function(response) {
            $("#student_list").empty();
            $("#student_list").html(response);
            $("#waiting_message").empty();
          }
        });
      });
    });
  </script>
  {{-- cloning the section --}}
  <script>
    $(document).ready(function() {
      $(".addField2").click(function() {
        $('.dataBlock2').find('.subject').select2("destroy");
        $(".dataBlock2")
          .eq(0)
          .clone()
          .find("input").val("").end() // ***
          .show()
          .insertAfter(".dataBlock2:last");
        $('.dataBlock2').find('.subject').select2();
      });
      $('.cancel2').on('click', function() {
        var count = $(".dataBlock2").length;
        if (count > 1) {
          $('.dataBlock2:last').remove();
        }
      });
    });
  </script>
@endsection

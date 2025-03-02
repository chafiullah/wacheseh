@extends('layouts.master')

@section('extrastyle')
  <link href="{{ URL::asset('assets/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('assets/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('assets/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('assets/css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('content')
  <!-- page content -->
  <div class="right_col" role="main">
    <div class="">
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h4 class="text-center text-info">"At the bottom of this page you will find a Downloadable Excel file. That is the sample file. So read carefully the instructions first then get to the bottom of this page and download the file. Then fill up that file with the grades and upload here."</h4>
            </div>
            <div class="x_content">
              <form action="{{ route('mark.import') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="">Excel File:</label>
                    <input type="file" class="form-control" name="file" required>
                  </div>
                  <div class="form-group col-md-12">
                    <button type="submit" class="btn btn-success pull-right">import</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="x_panel">
            <div class="x_title">
             <h3 class="text-center">Here you can generate list to import it later</h3>
            </div>
            <div class="x_content">
              <form method="POST" action="{{route('mark.import.generate')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-row">
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <label for="">Select Academic Year:</label>
                    <select name="academic_year" class="form-control" id="academic_year">
                      <option></option>
                      @foreach($academic_years as $year)
                        <option value="{{$year->id}}">{{$year->alias}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <label for="">Select Semester:</label>
                    <select name="semester" class="form-control" required>
                      <option value="{{ config('constant.sem1') }}">{{ config('constant.sem1') }}</option>
                      <option value="{{ config('constant.sem2') }}">{{ config('constant.sem2') }}</option>
                      <option value="{{ config('constant.sem3') }}">{{ config('constant.sem3') }}</option>
                    </select>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <label for="">Select Class:</label>
                    <select name="class_id" class="form-control select2" id="class_id" required>
                      <option></option>
                      @foreach($classes as $class)
                        <option value="{{$class->id}}">{{$class->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <label for="">Select Course:</label>
                    <select name="course_id" class="form-control select2" id="select_course" required>
                      @foreach($courses as $course)
                        <option value="{{$course->id}}">{{$course->course_name}}</option>
                      @endforeach
                    </select>
                    <small class="text-danger" id="waiting_message"></small>
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12">
                    <button type="submit" class="btn btn-success pull-right" style="margin-top: 10px">generate list</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
          @if(Request::routeIs('mark.import.generate'))
            <div class="x_panel">
              <div class="x_content table-responsive">
                <h4 class="text-danger">Download this format as an <b>Excel</b> file. Make sure you don't delete the heading row! If you delete the heading row, grades won't be uploaded. And don't modify any data that is generated, just put the grades and signature.</h4>
                <table class="table table-striped dataTable">
                  <thead>
                  <tr>
                    <th>academic_year</th>
                    <th>semester</th>
                    <th>student_database_id</th>
                    <th>name</th>
                    <th>class_database_id</th>
                    <th>course_database_id</th>
                    <th>n1_mark</th>
                    <th>n2_mark</th>
                    <th>signature</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach ($students as $student)
                    <tr>
                      <td>{{$student->academic_year}}</td>
                      <td>{{$semester}}</td>
                      <td>{{ $student->student->id }}</td>
                      <td>{{ $student->student->name }}</td>
                      <td>{{$student->department_id}}</td>
                      <td>{{$course_id}}</td>
                      <td></td>
                      <td></td>
                      <td>{{auth()->user()->name}}</td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection

@section('extrascript')
  <!-- dataTables -->
  <script src="{{ URL::asset('assets/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/dataTables.bootstrap.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/dataTables.buttons.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/buttons.bootstrap.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/buttons.flash.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/buttons.html5.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/buttons.print.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/jszip.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/pdfmake.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/vfs_fonts.js') }}"></script>
  <script src="{{ URL::asset('assets/js/sweetalert.min.js') }}"></script>

  <script>
    $(document).ready(function() {
      //datatables code
      var handleDataTableButtons = function() {
        if ($(".dataTable").length) {
          $(".dataTable").DataTable({
            responsive: true,
            pageLength: 3,
            dom: "Bfrtip",
            buttons: [{
              text: 'Download Excel',
              extend: "excel",
              className: "btn-success btn-sm"
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
    //   select2
      $('.select2').select2();
    });
  </script>

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
        console.log(class_id + ' : ' + academic_year);
        $.ajax({
          type: "get",
          url: "{{ route('get-courses-by-outline.list') }}",
          data: {
            "class_id": class_id,
            "academic_year":academic_year
          },
          dataType: "html",
          success: function(response) {
            $("#select_course").empty();
            $("#select_course").html(response);
            $("#waiting_message").empty();
          }
        });
      });
    });
  </script>
@endsection

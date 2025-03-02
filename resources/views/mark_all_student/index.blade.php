@extends('layouts.master')

@section('title', 'All Student by Course')

@section('extrastyle')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
@endsection

@section('content')
  <div class="right_col" role="main">
    <div class="">
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-12 table-responsive">
            <div class="x_title">
                <h2 class='text-danger'></h2>
            </div>
          <div class="x_panel">
              {{-- individual marks --}}
            <div class="x_content">
              <div class="row">
                  <div class="col-md-12">
                      <h2>Individual Student Mark:</h2>
                        <form class="form-horizontal form-label-left" novalidate method="POST" action="{{route('mark.sheet')}}">
                        {{@csrf_field()}}
                            <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="file">Please Enter Roll: <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="student_id" class="form-control select2">
                                <option></option>
                                @foreach ($students as $student)
                                    <option value="{{ $student->studentID }}">{{ $student->studentID.' - '.$student->firstName.' '.$student->lastName }}</option>
                                @endforeach
                                </select>
                                <!--<input id="file" type="text" class="form-control col-md-7 col-xs-12"  name="student_id" value="{{old('student_id')}}" placeholder="ex: 1101031" required="required">-->
                                <!--  <span class="text-danger">{{ $errors->first('student_id') }}</span>-->
                            </div>
                            </div>
                            <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <button id="send" type="submit" class="btn btn-success"><i class="fa fa-check"> Find</i></button>
                            </div>
                            </div>
                        </form>
                  </div>
              </div>
            </div>
            {{-- completed --}}
            <div class="x_content">
              <div class="row">
                  <div class="col-md-12">
                      <h2>Students that completed:</h2>
                        <form class="form-horizontal form-label-left" novalidate method="POST" action="{{route('allStudent.course.report')}}">
                        {{@csrf_field()}}
                            <div class="item form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="file">Select a course: <span class="required">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                  <select name="courseID" class="form-control select2">
                                  <option></option>
                                  @foreach ($courses as $course)
                                      <option value="{{ $course->id }}">{{ $course->course_code.' - '.$course->course_name }}</option>
                                  @endforeach
                                  </select>
                                  <!--<input id="file" type="text" class="form-control col-md-7 col-xs-12"  name="student_id" value="{{old('student_id')}}" placeholder="ex: 1101031" required="required">-->
                                  <!--  <span class="text-danger">{{ $errors->first('student_id') }}</span>-->
                              </div>
                            </div>
                            <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <button id="send" type="submit" class="btn btn-success"><i class="fa fa-check"> Find</i></button>
                            </div>
                            </div>
                        </form>
                  </div>
              </div>
            </div>
            {{-- enrolled in this course --}}
            <div class="x_content">
              <div class="row">
                  <div class="col-md-12">
                      <h2>Students Currently Enrolled In: [By Course]</h2>
                        <form class="form-horizontal form-label-left" novalidate method="POST" action="{{route('allStudent.course.enrolled')}}">
                        {{@csrf_field()}}
                          <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="file">Select a course: <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="courseID" class="form-control select2">
                                <option></option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->course_code.' - '.$course->course_name }}</option>
                                @endforeach
                                </select>
                                <!--<input id="file" type="text" class="form-control col-md-7 col-xs-12"  name="student_id" value="{{old('student_id')}}" placeholder="ex: 1101031" required="required">-->
                                <!--  <span class="text-danger">{{ $errors->first('student_id') }}</span>-->
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <button id="send" type="submit" class="btn btn-success"><i class="fa fa-check"> Find</i></button>
                            </div>
                          </div>
                        </form>
                  </div>
              </div>
            </div>
            {{-- by student --}}
            <div class="x_content">
              <div class="row">
                  <div class="col-md-12">
                      <h2>Students Currently Enrolled In: [By Student]</h2>
                        <form class="form-horizontal form-label-left" novalidate method="POST" action="{{route('allStudent.course.enrolled.student')}}">
                        {{@csrf_field()}}
                          <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="file">Select Student: <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="studentID" class="form-control select2">
                                <option></option>
                                @foreach ($students as $student)
                                    <option value="{{ $student->studentID }}">{{ $student->studentID.' - '.$student->firstName.' '.$student->lastName }}</option>
                                @endforeach
                                </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <button id="send" type="submit" class="btn btn-success"><i class="fa fa-check"> Find</i></button>
                            </div>
                          </div>
                        </form>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('extrascript')
  <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js
  "></script>
  <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap.min.js
  "></script>
  <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js
  "></script>
  <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.bootstrap.min.js
  "></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js
  "></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js
  "></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js
  "></script>
  <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js
  "></script>
  <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js
  "></script>
  <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.colVis.min.js
  "></script>
  <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap.min.js"></script>
  {{-- datepicker --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

<script>
    $(document).ready(function () {
        $('.select2').select2({
            placeholder: 'select a value...'
        });
    });
</script>

  <script>
    $(document).ready(function () {
      $('.datepicker').datepicker({
        format: "mm-yyyy",
        startView: "months", 
        minViewMode: "months",
        orientation: "top right",
        autoclose: true
      });
    });
  </script>

<script>
    $(document).ready(function () {
    var table = $('.datatable').DataTable( {
        dom: 'Bfrtip',
        pageLength:10,
        columnDefs: [
        // { visible: false, targets: [6] }
        ],
        buttons: [
        { extend: 'excel', className: 'btn btn-primary',text:'Export to Excel' },
        { extend: 'pdf', className: 'btn btn-success', text:'Export to PDF' },
        { extend: 'colvis',columns: ':not(.noVis)', className:'btn btn-info', text:'Column Visibility'}
        ],
    });
    table.buttons().container()
    .appendTo( $('.col-sm-6:eq(0)', table.table().container() ) );
    });
</script>

@endsection

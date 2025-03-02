@extends('layouts.master')

@section('title', 'Mark')

@section('content')
  <!-- page content -->
  <div class="right_col" role="main">
    <div class="">
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_content">
              <form action="{{ route('mark.update', $mark->id) }}" method="post">
                @csrf
                @method('PATCH')
                <div class="form-row">
                  <div class="form-group col-md-3 col-sm-12">
                    <label for="">Select Semester: <span class="text-danger">*</span></label>
                    <select name="semester_id" class="form-control" required>
                      <option value="{{ config('constant.sem1') }}" @if ($mark->getOriginal('semester_id') == 1) selected @endif>{{ config('constant.sem1') }}</option>
                      <option value="{{ config('constant.sem2') }}" @if ($mark->getOriginal('semester_id') == 2) selected @endif>{{ config('constant.sem2') }}</option>
                      <option value="{{ config('constant.sem3') }}" @if ($mark->getOriginal('semester_id') == 3) selected @endif>{{ config('constant.sem3') }}</option>
                    </select>
                  </div>
                  <div class="form-group col-md-3 col-sm-12">
                    <label for="">Academic Year: <span class="text-danger">*</span></label>
                    <select name="academic_year" class="form-control subject" id="academic_year" required>
                      <option></option>
                      @foreach ($academic_years as $year)
                        <option value="{{ $year->academic_year }}" @if($mark->academic_year==$year->academic_year )selected @endif>
                          {{ $year->academic_year }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-md-3 col-sm-12">
                    <label for="">Class: <span class="text-danger">*</span></label>
                    <select name="class_id" class="form-control subject" id="class_id" required>
                      <option></option>
                      @foreach ($classes as $class)
                        <option value="{{ $class->id }}" @if ($mark->getOriginal('class_id') == $class->id) selected @endif>
                          {{ $class->name }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-md-3 col-sm-12">
                    <label for="">Select Student: <span class="text-danger">*</span></label>
                    <select name="student_id" class="form-control subject" required>
                      @foreach ($students as $student)
                        <option value="{{ $student->id }}" @if ($mark->getOriginal('student_id') == $student->id) selected @endif>
                          {{ $student->name }}
                        </option>
                      @endforeach
                    </select>
                    <small class="text-danger" id="waiting_message"></small>
                  </div>
                </div>
                <div class="form-row dataBlock2" style="margin-bottom: 5%">
                  <div class="form-group col-md-12">
                    <label for="">Course:<span class="text-danger">*</span></label>
                    <select name="course_id" class="form-control subject">
                      <option></option>
                      @foreach ($courses as $item)
                        <option value="{{ $item->id }}" @if ($mark->getOriginal('course_id') == $item->id) selected @endif>{{ $item->course_name . ' - cof:' . $item->coefficient }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="">N1 Grade:<span class="text-danger">*</span></label>
                    <input type="number" name="n1_mark" class="form-control" value="{{ $mark->n1_mark }}" required>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="">N2 Grade:<span class="text-danger">*</span></label>
                    <input type="number" name="n2_mark" class="form-control" value="{{ $mark->n2_mark }}" required>
                  </div>
                  <div class="form-group col-md-12">
                    <label for="">Signature:</label>
                    <input type="text" class="form-control" name="signature" value="{{ $mark->signature }}" required>
                  </div>
                </div>
                <div class="form-group col-md-12">
                  <button type="submit" class="btn btn-success pull-right">submit</button>
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
  <script>
    $(document).ready(function() {
      $(".subject").select2({
        placeholder: "Select a value",
        allowClear: true
      });
    });
  </script>
@endsection

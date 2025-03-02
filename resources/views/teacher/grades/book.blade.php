@extends('layouts.master')

@section('title', 'Course Grade Book')


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
              <h4 class="text-info text-center">Grade Book of <b>{{ $department->name }} ||</b> Course: <b>{{ $course->course_name }}</b></h4>
            </div>
            <div class="x_content">
              <form action="{{ route('teacher.grade.book.store') }}" method="post">
                @csrf
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <input type="hidden" name="class_id" value="{{ $department->id }}">
                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Name</th>
                          <th>Year</th>
                          <th>Semester</th>
                          <th>N1(50%)</th>
                          <th>N2(50%)</th>
                          <th>Signature</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($students as $item)
                          {{--By default the system will fetch the grade of first semester--}}
                          @php
                            $grade=\App\Mark::where('academic_year',\App\Helper\Helper::getActiveAcademicYear()->academic_year)->where('semester',$term)->where('student_id',$item->student->id)->where('class_id',$item->department_id)->where('course_id',$course->id)->first();
                          @endphp
                          <tr>
                            <td>
                              {{ $item->student->student_id }}
                              <input type="hidden" name="student_ids[]" class="form-control" value="{{ $item->student->id }}" readonly>
                            </td>
                            <td>{{ $item->student->first_name . ' ' . $item->student->last_name }}</td>
                            <td><input type="text" name="academic_year" class="form-control" value="{{\App\Helper\Helper::getActiveAcademicYear()->academic_year}}" readonly></td>
                            <td>
                              <input type="text" name="semesters[]" class="form-control" value="{{$term}}" readonly>
                            </td>
                            <td>
                              <input type="number" name="n1_marks[]" class="form-control" value="{{$grade->n1_mark}}">
                            </td>
                            <td>
                              <input type="number" name="n2_marks[]" class="form-control" value="{{$grade->n2_mark}}">
                            </td>
                            <td>
                              <input type="text" name="signatures[]" class="form-control" value="{{ auth()->user()->name }}">
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                  <div class="form-group col-md-12">
                    <button type="submit" class="btn btn-success pull-right">add</button>
                  </div>
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
  <!-- /page content -->
@endsection

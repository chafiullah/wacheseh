@extends('admin_student.master')
@section('title')
Student || Course
@endsection
@section('main')
  <section class="content-header border border-info">
      <div class="row">
        <div class="col-md-6 col-12 table-responsive">
          <table class="table table-striped">
            <tbody>
              <tr>
                <td>Student ID:</td>
                <td>{{ $student->Registration_Number }}</td>
              </tr>
              <tr>
                <td>Student Name:</td>
                <td>{{ $student->Full_Name }}</td>
              </tr>
              <tr>
                <td>Enrolled Semester:</td>
                <td>{{ $student->Enrollment_Semester }}</td>
              </tr>
              <tr>
                <td>Batch:</td>
                <td>{{ $student->Batch }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="col-md-6 col-12 table-responsive">
          <table class="table table-striped">
            <tbody>
              <tr>
                <td>Department:</td>
                <td>{{ $student->Program }}</td>
              </tr>
              <tr>
                <td>Current Status:</td>
                <td>{{ $student->Current_status }}</td>
              </tr>
              <tr>
                <td>Current Semester:</td>
                <td>{{ $student->Current_semester }}</td>
              </tr>
              <tr>
                <td>Current Session:</td>
                <td>{{ Helper::current_semester() }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
  </section>

  <section class="content">
    <div class="row mt-3">
      {{-- first semester --}}
      <div class="col-md-6 col-12 table-responsive">
        <h4 class="text-center">First Semester</h4>
        <table class="table table-striped">
          <thead>
            <th>Course Code</th>
            <th>Course Title</th>
            <th>Credit</th>
          </thead>
          <tbody>
            @php
                $total_credit = 0;
            @endphp
            @foreach ($syllabus_courses as $item)
                @if ($item->level_term == 'l1t1')
                  <tr>
                    <td>{{ $item->course->course_code }}</td>
                    <td>{{ $item->course->course_name }}</td>
                    <td>{{ $item->course->credit }}</td>
                  </tr>
                  @php
                      $total_credit = $total_credit+$item->course->credit;
                  @endphp
                @endif
            @endforeach
            <tr>
              <td></td>
              <td>Total Credit:</td>
              <td>{{ $total_credit }}</td>
            </tr>
          </tbody>
        </table>
      </div>
      {{-- second semester --}}
      <div class="col-md-6 col-12 table-responsive">
        <h4 class="text-center">Second Semester</h4>
        <table class="table table-striped">
          <thead>
            <th>Course Code</th>
            <th>Course Title</th>
            <th>Credit</th>
          </thead>
          <tbody>
            @php
                $total_credit = 0;
            @endphp
            @foreach ($syllabus_courses as $item)
                @if ($item->level_term == 'l1t2')
                  <tr>
                    <td>{{ $item->course->course_code }}</td>
                    <td>{{ $item->course->course_name }}</td>
                    <td>{{ $item->course->credit }}</td>
                  </tr>
                  @php
                      $total_credit = $total_credit+$item->course->credit;
                  @endphp
                @endif
            @endforeach
            <tr>
              <td></td>
              <td>Total Credit:</td>
              <td>{{ $total_credit }}</td>
            </tr>
          </tbody>
        </table>
      </div>
      {{-- third semester --}}
      <div class="col-md-6 col-12 table-responsive">
        <h4 class="text-center">Third Semester</h4>
        <table class="table table-striped">
          <thead>
            <th>Course Code</th>
            <th>Course Title</th>
            <th>Credit</th>
          </thead>
          <tbody>
            @php
                $total_credit = 0;
            @endphp
            @foreach ($syllabus_courses as $item)
                @if ($item->level_term == 'l2t1')
                  <tr>
                    <td>{{ $item->course->course_code }}</td>
                    <td>{{ $item->course->course_name }}</td>
                    <td>{{ $item->course->credit }}</td>
                  </tr>
                  @php
                      $total_credit = $total_credit+$item->course->credit;
                  @endphp
                @endif
            @endforeach
            <tr>
              <td></td>
              <td>Total Credit:</td>
              <td>{{ $total_credit }}</td>
            </tr>
          </tbody>
        </table>
      </div>
      {{-- Fourth semester --}}
      <div class="col-md-6 col-12 table-responsive">
        <h4 class="text-center">Fourth Semester</h4>
        <table class="table table-striped">
          <thead>
            <th>Course Code</th>
            <th>Course Title</th>
            <th>Credit</th>
          </thead>
          <tbody>
            @php
                $total_credit = 0;
            @endphp
            @foreach ($syllabus_courses as $item)
                @if ($item->level_term == 'l2t2')
                  <tr>
                    <td>{{ $item->course->course_code }}</td>
                    <td>{{ $item->course->course_name }}</td>
                    <td>{{ $item->course->credit }}</td>
                  </tr>
                  @php
                      $total_credit = $total_credit+$item->course->credit;
                  @endphp
                @endif
            @endforeach
            <tr>
              <td></td>
              <td>Total Credit:</td>
              <td>{{ $total_credit }}</td>
            </tr>
          </tbody>
        </table>
      </div>
      {{-- Fifth semester --}}
      <div class="col-md-6 col-12 table-responsive">
        <h4 class="text-center">Fifth Semester</h4>
        <table class="table table-striped">
          <thead>
            <th>Course Code</th>
            <th>Course Title</th>
            <th>Credit</th>
          </thead>
          <tbody>
            @php
                $total_credit = 0;
            @endphp
            @foreach ($syllabus_courses as $item)
                @if ($item->level_term == 'l3t1')
                  <tr>
                    <td>{{ $item->course->course_code }}</td>
                    <td>{{ $item->course->course_name }}</td>
                    <td>{{ $item->course->credit }}</td>
                  </tr>
                  @php
                      $total_credit = $total_credit+$item->course->credit;
                  @endphp
                @endif
            @endforeach
            <tr>
              <td></td>
              <td>Total Credit:</td>
              <td>{{ $total_credit }}</td>
            </tr>
          </tbody>
        </table>
      </div>
      {{-- Sixth semester --}}
      <div class="col-md-6 col-12 table-responsive">
        <h4 class="text-center">Sixth Semester</h4>
        <table class="table table-striped">
          <thead>
            <th>Course Code</th>
            <th>Course Title</th>
            <th>Credit</th>
          </thead>
          <tbody>
            @php
                $total_credit = 0;
            @endphp
            @foreach ($syllabus_courses as $item)
                @if ($item->level_term == 'l3t2')
                  <tr>
                    <td>{{ $item->course->course_code }}</td>
                    <td>{{ $item->course->course_name }}</td>
                    <td>{{ $item->course->credit }}</td>
                  </tr>
                  @php
                      $total_credit = $total_credit+$item->course->credit;
                  @endphp
                @endif
            @endforeach
            <tr>
              <td></td>
              <td>Total Credit:</td>
              <td>{{ $total_credit }}</td>
            </tr>
          </tbody>
        </table>
      </div>
      {{-- Seventh semester --}}
      <div class="col-md-6 col-12 table-responsive">
        <h4 class="text-center">Seventh Semester</h4>
        <table class="table table-striped">
          <thead>
            <th>Course Code</th>
            <th>Course Title</th>
            <th>Credit</th>
          </thead>
          <tbody>
            @php
                $total_credit = 0;
            @endphp
            @foreach ($syllabus_courses as $item)
                @if ($item->level_term == 'l4t1')
                  <tr>
                    <td>{{ $item->course->course_code }}</td>
                    <td>{{ $item->course->course_name }}</td>
                    <td>{{ $item->course->credit }}</td>
                  </tr>
                  @php
                      $total_credit = $total_credit+$item->course->credit;
                  @endphp
                @endif
            @endforeach
            <tr>
              <td></td>
              <td>Total Credit:</td>
              <td>{{ $total_credit }}</td>
            </tr>
          </tbody>
        </table>
      </div>
      {{-- Eighth semester --}}
      <div class="col-md-6 col-12 table-responsive">
        <h4 class="text-center">Eighth Semester</h4>
        <table class="table table-striped">
          <thead>
            <th>Course Code</th>
            <th>Course Title</th>
            <th>Credit</th>
          </thead>
          <tbody>
            @php
                $total_credit = 0;
            @endphp
            @foreach ($syllabus_courses as $item)
                @if ($item->level_term == 'l4t2')
                  <tr>
                    <td>{{ $item->course->course_code }}</td>
                    <td>{{ $item->course->course_name }}</td>
                    <td>{{ $item->course->credit }}</td>
                  </tr>
                  @php
                      $total_credit = $total_credit+$item->course->credit;
                  @endphp
                @endif
            @endforeach
            <tr>
              <td></td>
              <td>Total Credit:</td>
              <td>{{ $total_credit }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>

@endsection


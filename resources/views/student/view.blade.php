@extends('layouts.master')

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
              <h2>Student's Details</h2>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <div class="row">
                <div class="col-md-2 text-right">
                  <img src="{{ asset(config('constant.asset_url') . 'student_images/' . $studentInfo->image) }}" alt="no-image">
                </div>
                <div class="col-md-6 col-md-offset-2">
                  <table class="table table-striped">
                    <tbody>
                      <tr>
                        <td><b>Name:</b></td>
                        <td>{{ $studentInfo->name }}</td>
                      </tr>
                      <tr>
                        <td><b>Gender</b></td>
                        <td>{{ $studentInfo->gender }}</td>
                      </tr>
                      <tr>
                        <td><b>Student ID:</b></td>
                        <td>{{ $studentInfo->student_id }}</td>
                      </tr>
                      <tr>
                        <td><b>Student Class:</b></td>
                        <td>{{ $studentInfo->class }}</td>
                      </tr>
                      <tr>
                        <td><b>Student Series:</b></td>
                        <td>{{ $studentInfo->student_series }}</td>
                      </tr>
                      <tr>
                        <td><b>Student Region:</b></td>
                        <td>{{ $studentInfo->region }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                {{-- details --}}
                <div class="col-md-4">
                  <table class="table table-borderless">
                    <tbody>
                      <tr>
                        <td><b>Date of Birth</b></td>
                        <td>{{ $studentInfo->date_of_birth }}</td>
                      </tr>
                      <tr>
                        <td><b>Email</b></td>
                        <td>{{ $studentInfo->email }}</td>
                      </tr>
                      <tr>
                        <td><b>Phone</b></td>
                        <td>{{ $studentInfo->phone }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="col-md-4">
                  <table class="table table-borderless">
                    <tbody>

                      <tr>
                        <td><b>Legal Guidance</b></td>
                        <td>{{ $studentInfo->legal_guidance }}</td>
                      </tr>
                      <tr>
                        <td><b>Guidance Phone</b></td>
                        <td>{{ $studentInfo->guidance_phone }}</td>
                      </tr>
                      <tr>
                        <td><b>Guidance Email</b></td>
                        <td>{{ $studentInfo->guidance_email }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="col-md-4">
                  <table class="table table-borderless">
                    <tbody>
                      <tr>
                        <td><b>Address</b></td>
                        <td>{{ $studentInfo->address }}</td>
                      </tr>
                      <tr>
                        <td><b>Current Status</b></td>
                        <td>{{ $studentInfo->status }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="col-md-12 text-center">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Downloable Contents</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><a href="{{ asset(config('constant.asset_url') . 'student_admission_documents/' . $studentInfo->birth_certificate) }}" download>Download Birth Certificate Copy</a></td>
                      </tr>
                      <tr>
                        <td> <a href="{{ asset(config('constant.asset_url') . 'student_admission_documents/' . $studentInfo->report_card) }}" download>Download Previous Academic Records</a></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
{{--                <div class="col-md-12">--}}
{{--                  <form action="{{ route('teacher.student.update.remarks',$studentInfo->id) }}" method="POST">--}}
{{--                  @csrf--}}
{{--                  @method("PATCH")--}}
{{--                    <div class="form-row">--}}
{{--                      <div class="col-lg-12 col-md-12 form-group">--}}
{{--                        <label>Remarks:</label>--}}
{{--                        <textarea class="form-control" name="remarks">{{ $studentInfo->remarks }}</textarea>--}}
{{--                        <button class="btn btn-success pull-right" style="margin-top:2%">Update Remarks</button>--}}
{{--                      </div>--}}
{{--                    </div>--}}
{{--                  </form>--}}
{{--                </div>--}}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

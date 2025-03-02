@extends('admin_student.master')

@section('main')
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          {{-- <a href="{{ URL::to('/profile-update') }}" class="btn btn-md btn-outline-info"><i class="fa fa-refresh"></i> Update Profile</a> --}}
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Profile Page</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <section class="content">
    <!-- Row  box -->
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
          <div class="card-body">
            <table class="table table-striped">
              <tr>
                <td class="text-bold">Name:</td>
                <td>{{ $student->first_name }} {{ $student->last_name }}</td>
              </tr>
              <tr>
                <td class="text-bold">Current Class:</td>
                <td>{{ $student->class }}</td>
              </tr>
              <tr>
                <td class="text-bold">Student ID:</td>
                <td>{{ $student->student_id }}</td>
              </tr>
              <tr>
                <td class="text-bold">Current Academic Year:</td>
                <td>{{ Helper::getActiveAcademicYear()->alias }}</td>
              </tr>
              <tr>
                <td class="text-bold">Total Payment Made in the Current Academic Year:</td>
                <td>{{ $totalPaid }}</td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div><!-- Row  box end with Academic Information -->
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="card">
          <h5 class="card-header text-info ">Basic Information</h5>
          <div class="card-body">
            <table class="table table-stripe">
              <tbody>
                <tr>
                  <th>First Name:</th>
                  <td>{{ $student->first_name }}</td>
                </tr>
                <tr>
                  <th>Last Name:</th>
                  <td>{{ $student->last_name }}</td>
                </tr>
                <tr>
                  <th>Date of Birth:</th>
                  <td>{{ $student->date_of_birth }}</td>
                </tr>
                <tr>
                  <th>Legal Guidance:</th>
                  <td>{{ $student->legal_guidance }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="card">
          <h5 class="card-header">Contact Information</h5>
          <div class="card-body ">
            <table class="table">
              <tbody>
                <tr>
                  <th>Email:</th>
                  <td>{{ $student->email }}</td>
                </tr>
                <tr>
                  <th>Phone:</th>
                  <td> {{ $student->phone }}</td>
                </tr>
                <tr>
                  <th>Address:</th>
                  <td> {{ $student->address }}</td>
                </tr>
                <tr>
                  <th>Legal Guidance Phone:</th>
                  <td>{{ $student->guidance_phone }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

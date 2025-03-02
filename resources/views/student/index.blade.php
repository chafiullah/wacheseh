@extends('layouts.master')

@section('title', 'All - Students')

@section('extrastyle')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.bootstrap.min.css">
@endsection

@section('content')
  <!-- page content -->
  <div class="right_col" role="main">
    <div class="">
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-12">
          <div class="x_panel">
            {{-- department wise students --}}
            <div class="x_title">
              <h3 class="text-info">Active Academic Semester <b>{{\App\Helper\Helper::getActiveAcademicYear()->alias}}</b></h3>
              <a href="{{ route('student.all_export.filter', 'Active') }}" class="btn btn-success">
                @if ($type == 'Active')
                  <i class="fas fa-check-circle    "></i>
                @endif Active-Students
              </a>
              <a href="{{ route('student.all_export.filter', 'Withdrawn') }}" class="btn btn-warning">
                @if ($type == 'Inactive')
                  <i class="fas fa-check-circle    "></i>
                @endif Withdrawn-Students
              </a>
              <a href="{{ route('student.all_export.filter', 'Expelled') }}" class="btn btn-info">
                @if ($type == 'Graduate')
                  <i class="fas fa-check-circle    "></i>
                @endif Expelled-Students
              </a>
              <a href="{{ route('student.all_export.filter', 'Alumni') }}" class="btn btn-danger">
                @if ($type == 'Withdrawn')
                  <i class="fas fa-check-circle    "></i>
                @endif Alumni-Students
              </a>
              <div class="clearfix"></div>
            </div>

            <div class="x_content table-responsive">
              <table class="table table-striped responsive nowrap">
                <thead>
                  <tr>
                    <th>Class</th>
                    <th>Series</th>
                    <th>Name</th>
                    <th>Student Id</th>
                    {{-- <th>Image</th> --}}
                    <th>Gender</th>
                    <th>Date of Birth</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($students as $student)
                    <tr>
                      <td>{{ $student->class }}</td>
                      <td>{{ $student->student_series }}</td>
                      <td>{{ $student->name }}</td>
                      <td>{{ $student->student_id }}</td>
                      {{-- <td>
                        <img src="{{ asset(config('constant.asset_url') . 'student_images/' . $student->image) }}" width="100" height="90" alt="no-image" class="img-circle">
                      </td> --}}
                      <td>{{ $student->gender }}</td>
                      <td>{{ $student->date_of_birth }}</td>
                      <td>{{ $student->phone }}</td>
                      <td>
                        @if ($student->status == config('constant.active'))
                          <span class="text-success">{{ $student->status }}</span>
                        @else
                          <span class="text-danger">{{ $student->status }}</span>
                        @endif
                      </td>
                      <td>
                        @permission('view-student-profile')
                          <a href="{{ route('studentInfo.show', $student->id) }}" class="btn btn-success btn-sm" title="view or download student profile"><i class="fa fa-eye"></i></a>
                        @endpermission

                        @permission('reset-student-password')
                          <a href="{{ route('student.password.admin.reset', $student->id) }}" class="btn btn-info btn-sm" title="reset password to 'student#'"><i class="fa fa-key"></i></a>
                        @endpermission

                        @permission('edit-student-profile')
                          <a href="{{ route('studentInfo.edit', $student->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                        @endpermission
                        @permission('add-comment')
                          <a href="{{ route('student.comment.index', $student->id) }}" class="btn btn-info btn-sm"><i class="fa fa-comment"></i></a>
                        @endpermission
                        {{-- <a href="#" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to remove this student?')"><i class="fa fa-trash"></i></a> --}}
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /page content -->
@endsection

@section('extrascript')
  <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.colVis.min.js"></script>
  <script>
    $(document).ready(function() {
      var table = $('.table').DataTable({
        dom: 'Bfrtip',
        pageLength: 15,
        "aaSorting": [],
        buttons: [{
            extend: 'excel',
            className: 'btn btn-primary',
            text: 'Export to Excel'
          },
          {
            extend: 'pdf',
            className: 'btn btn-success',
            text: 'Export to PDF'
          },
          {
            extend: 'colvis',
            columns: ':not(.noVis)',
            className: 'btn btn-info',
            text: 'Column Visibility'
          }
        ]
      });
      table.buttons().container()
        .appendTo($('.col-sm-6:eq(0)', table.table().container()));
    });
  </script>
@endsection

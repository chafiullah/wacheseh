@extends('layouts.master')

@section('title', 'All-Students')

@section('extrastyle')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.bootstrap.min.css">
  {{-- <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css"> --}}
@endsection

@section('content')
        <!-- page content -->
        <div class="right_col" role="main">
         <div class="">
           <div class="clearfix"></div>
           <div class="row">
             <div class="col-md-12">
              <div class="x_panel">
                  @if (Request::routeIs('allStudent.course.report'))
                      <div class="x_content table-responsive">
                          <h2>Student that completed : <b>{{ $course->course_code.' - '.$course->course_name }}</b></h2>
                          <br>
                          <table class="table table-striped">
                              <thead>
                                  <th>Student ID</th>
                                  <th>First Name</th>
                                  <th>Last Name</th>
                                  <th>Grade Letter</th>
                              </thead>
                              <tbody>
                                  @foreach ($studentsCompleted as $item)
                                      <tr>
                                          <td>{{ $item->student->studentID }}</td>
                                          <td>{{ $item->student->firstName }}</td>
                                          <td>{{ $item->student->lastName }}</td>
                                          <td>{{ $item->grade_letter }}</td>
                                      </tr>
                                  @endforeach
                              </tbody>
                          </table>
                      </div>
                  @endif

                  @if (Request::routeIs('allStudent.course.enrolled'))
                  <div class="x_content table-responsive">
                      <h2>Student Enrolled In : <b>{{ $course->course_code.' - '.$course->course_name }}</b></h2>
                      <br>
                      <table class="table table-striped responsive nowrap">
                        <thead>
                          <th>Student ID</th>
                          <th>Student SSN</th>
                          <th>Program</th>
                          <th>Program Started</th>
                          <th>First Name</th>
                          <th>Middle Name</th>
                          <th>Last Name</th>
                          <th>Gender</th>
                          <th>Date of Birth</th>
                          <th>Email</th>
                          <th>Phone</th>
                          <th>Address</th>
                          <th>City</th>
                          <th>State</th>
                          <th>Zip</th>
                          <th>Academic Status</th>
                          {{-- <th>Total Tuition</th>
                          <th>Total Balance</th>
                          <th>Total Paid</th>
                          <th>Action</th> --}}
                        </thead>
                        <tbody>
                          @foreach ($students as $student)
                            {{-- @php
                                $totalPaid = \App\Receivable::where('studentID',$student->studentID)->where('paidFor',1)->sum('amount');
                                $totalBalance = $student->totalTution - $totalPaid;
                            @endphp --}}
                            <tr>
                              <td>{{ $student->studentID  }}</td>
                              <td>{{ $student->student->ssn }}</td>
                              <td>{{ $student->student->department->short_name }}</td>
                              <td>{{ $student->student->studentSession }}</td>
                              <td>{{ $student->student->firstName }}</td>
                              <td>{{ $student->student->middleName }}</td>
                              <td>{{ $student->student->lastName }}</td>
                              <td>{{ $student->student->gender }}</td>
                              <td>{{ $student->student->dob }}</td>
                              <td>{{ $student->student->email }}</td>
                              <td>{{ $student->student->phone }}</td>
                              <td>{{ $student->student->address }}</td>
                              <td>{{ $student->student->city }}</td>
                              <td>{{ $student->student->state }}</td>
                              <td>{{ $student->student->zip }}</td>
                              <td>{{ $student->student->academicStatus }}</td>
                              {{-- <td>{{ $student->totalTution }}</td>
                              <td>{{ $totalBalance }}</td>
                              <td>{{ $totalPaid }}</td> --}}
                              {{-- <td>
                                @permission('student-read')
                                  <a href="{{ URL::route('studentinfo.show',$student->studentID) }}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="view-student-profile"><i class="fas fa-user-circle    "></i></a>
                                @endpermission
                                  <a href="{{ URL::route('studentinfo.download',$student->studentID) }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="download-student-profile"><i class="fas fa-download    "></i></a>
                                @permission('student-edit')
                                  <a href="{{ URL::route('studentinfo.edit',$student->studentID) }}" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="edit-student-profile"><i class="fas fa-edit    "></i></a>
                                @endpermission
                                <a href="{{ route('fee.manual.index') }}" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="take-payment"><i class="fas fa-dollar-sign    "></i></a>
                                @if ($student->remarks != null)
                                    <a href="javascript:void(0)" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="{{ $student->remarks }}"><i class="fas fa-comments    "></i></a>
                                @endif
                              </td> --}}
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                  </div>
                  @endif
              </div>
             </div>
           </div>
         </div>
        </div>
        <!-- /page content -->
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
  {{-- <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script> --}}
  {{-- <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap.min.js"></script> --}}
    <script>
      $(document).ready(function () {
        var table = $('.table').DataTable( {
          dom: 'Bfrtip',
          pageLength:15,
          columnDefs: [
            { visible: false, targets: [1,2,3,5,7,8,11,12,13,14] }
          ],
          buttons: [
            { extend: 'excel', className: 'btn btn-primary',text:'Export to Excel' },
            { extend: 'pdf', className: 'btn btn-success', text:'Export to PDF' },
            { extend: 'colvis',columns: ':not(.noVis)', className:'btn btn-info', text:'Column Visibility'}
          ]
        });
      table.buttons().container()
      .appendTo( $('.col-sm-6:eq(0)', table.table().container() ) );
      });
    </script>
@endsection

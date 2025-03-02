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
                <div class="x_content">
                    <h2>Enrolled Courses of {{ $student->studentID.' - '.$student->firstName.' '.$student->lastName }}</b></h2>
                    <br>
                    <table class="table table-striped">
                      <thead>
                        <th>Course Code</th>
                        <th>Course Name</th>
                        <th>Course Credit</th>
                        <th>Action</th>
                      </thead>
                      <tbody>
                        @foreach ($courses as $enrolled)
                          <tr>
                            <td>{{ $enrolled->course->course_code }}</td>
                            <td>{{ $enrolled->course->course_name }}</td>
                            <td>{{ $enrolled->course->credit }}</td>
                            <td>
                                <a href="{{ route('allStudent.course.enrolled.remove',$enrolled->id) }}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="remove-from-enrolled-courses" onclick="return confirm('Are you sure to remove this course from the enrolled courses?')"><i class="fas fa-trash    "></i></a>
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
            // { visible: false, targets: [1,2,3,5,7,8,11,12,13,14] }
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

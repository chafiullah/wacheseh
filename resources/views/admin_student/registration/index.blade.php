@extends('admin_student.master')

@section('title')
Enrolled Courses
@endsection

@section('extrastyles')
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">
@endsection

@section('main')
  <div class="row mt-5">
    <div class="col-md-12 table-responsive">
      <table class="table table-striped dataTable">
        <thead>
          <th>#</th>
          <th>Course Code</th>
          <th>Course Name</th>
          <th>Course Credit</th>
        </thead>
        <tbody>
          @foreach ($courses as $item)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->course->course_code }}</td>
                <td>{{ $item->course->course_name }}</td>
                <td>{{ $item->course->credit }}</td>
              </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection

@section('extrascript')
  <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js
  "></script>
  <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js
  "></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js
  "></script>
  <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js
  "></script>
  <script>
    $(document).ready(function() {
      $('.dataTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
          { extend: 'pdfHtml5',messageTop: 'Enrolled Courses',text:'Download as PDF',className:'btn btn-success btn-md'}
        ]
      });
    });
  </script>
@endsection
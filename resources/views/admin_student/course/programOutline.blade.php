@extends('admin_student.master')


@section('extrastyles')
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
@endsection

@section('main')
  <div class="row mt-3">
    <div class="col-md-4 col-12">
      <div class="card">
        <div class="card-body table-responsive">
          <h4 class="p2">Exams</h4>
          <table class="table table-striped">
            <tbody>
              @foreach ($exams as $item)
                <tr>
                  <td>{{ $item->examName }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-md-8 col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="text-info text-center p-3">Your Program Outline For {{ auth()->user()->class }}</h4>
          <table class="table table-striped dTable">
            <thead>
              <tr>
                <th>Course Name</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($program_outline_courses as $item)
                <tr>
                  <td>{{ $item->course->course_name }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('extrascript')
  <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js
        "></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js
        "></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js
        "></script>
  <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js
        "></script>
  <script>
    $(document).ready(function() {
      $('.dTable').DataTable({
        dom: 'Bfrtip',
        ordering: false,
        buttons: [{
          extend: 'pdfHtml5',
          messageTop: 'Program Outline',
          text: 'Download as PDF',
          className: 'btn btn-success btn-md'
        }]
      });
    });
  </script>
@endsection

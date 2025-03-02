@extends('layouts.master')

@section('title', 'Enroll Students')

@section('extrastyle')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.bootstrap.min.css">
@endsection

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
              <h2>
                Enroll courses to <b>{{ $department->name }}</b> || Class Database ID:<b>{{ $department->id }}</b>
              </h2>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <form action="{{ route('enroll.course.store', $department->id) }}" method="post">
                @csrf
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="">Select Courses:</label>
                    <select name="courses[]" class="select2" multiple required>
                      <option></option>
                      @foreach ($courses as $item)
                        <option value="{{ $item->id }}">{{ $item->course_name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group col-md-12">
                  <button type="submit" class="btn btn-success pull-right">enroll</button>
                </div>
              </form>
            </div>
          </div>
          <div class="x_panel">
            <div class="x_content">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Coefficient</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($courses_enrolled as $item)
                    <tr>
                      <td>{{ $item->course->course_name }}</td>
                      <td>{{ $item->course->coefficient }}</td>
                      @permission('assign-courses-to-this-subject')
                      <td><a href="{{ route('course.enrolled.remove', $item->id) }}" class="btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                      @endpermission
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
  <script>
    $(document).ready(function() {
      var table = $('.table').DataTable({
        dom: 'Bfrtip',
        pageLength: 15,
        // columnDefs: [
        //   { visible: false, targets: [1,2,3,5,7,8,11,12,13,14] }
        // ],
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
          // { extend: 'colvis',columns: ':not(.noVis)', className:'btn btn-info', text:'Column Visibility'}
        ]
      });
      table.buttons().container()
        .appendTo($('.col-sm-6:eq(0)', table.table().container()));
    });
  </script>
  <script>
    $(document).ready(function() {
      $('.select2').select2({
        placeholder: 'select students..',
        allowClear: true
      });
    });
  </script>
@endsection

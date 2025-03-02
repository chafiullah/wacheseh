@extends('layouts.master')

@section('extrastyle')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.bootstrap.min.css">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
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
              @foreach ($programs as $item)
                <a href="{{ route('programs.outline.list', $item->id) }}" class="btn btn-info">{{ $item->name }} Courses</a>
              @endforeach
              <div class="clearfix"></div>
              <h4 class="text-info">Add course to {{ $thisProgram->short_name }} Program Outline</h4>
              <div class="clearfix"></div>
              <form action="{{ route('programs.outline.store') }}" method="post">
                @csrf
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="">Courses:</label>
                    <input type="hidden" name="programID" value="{{ $department->id }}">
                    <select name="courseID[]" class="form-control select2" multiple>
                      <option></option>
                      @foreach ($mainCourses as $item)
                        <option value="{{ $item->id }}">{{ $item->course_name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-md-12">
                    <button class="btn btn-success pull-right">add</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
          {{-- <div class="x_panel">
            <div class="x_content table-responsive">
              <form action="{{ route('programs.instruction.update', $program_instruction->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <textarea name="instruction" class="form-control summernote">{{ $program_instruction->instruction }}</textarea>
                  </div>
                  <div class="form-group col-md-12">
                    <button type="submit" class="btn btn-success pull-right">update</button>
                  </div>
                </div>
              </form>
            </div>
          </div> --}}
          <div class="x_panel">
            <div class="x_content">
              <h4 class="text-info text-center"><u><b>{{ $department->name }} - Program Outline</b></u></h4>
              <div class="clearfix"></div>
              <table id="datatable-buttons" class="table table-striped">
                <thead>
                  <th>Course Title</th>
                  <th>Action</th>
                </thead>

                <tbody>
                  @foreach ($courses as $item)
                    <tr>
                      <td>{{ $item->course->course_name }}</td>
                      <td>
                        <a href="{{ route('programs.outline.destroy', $item->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to remove this course?')"><i
                            class="fas fa-trash    "></i></a>
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
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
  <script>
    $(document).ready(function() {
      // select 2
      $('.select2').select2({
        placeholder: 'select a course..',
        allowCLear: true
      });
      // summernote
      $('.summernote').summernote();
      // data table
      var table = $('#datatable-buttons').DataTable({
        dom: 'Bfrtip',
        ordering: false,
        pageLength: 15,
        //   columnDefs: [
        //     { visible: false, targets: [1,3,4,6,8,11,12,13,14] }
        //   ],
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

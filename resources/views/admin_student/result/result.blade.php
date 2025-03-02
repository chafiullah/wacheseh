@extends('admin_student.master')

@section('extrastyles')
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">
@endsection


@section('main')
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Academic Results</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Academic Results</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <ul class="list-group">
              @foreach($academic_years as $year)
                <li class="list-group-item">
                  <a href="{{route('student.result.show',[$year->academic_year,$year->department_id])}}">View Result of {{$year->academic_year}}, {{\App\Department::find($year->department_id)->name}}</a>
                </li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
      @if (Request::routeIs('student.result.show'))
        <div class="col-md-12">
          <div class="card">
            <div class="card-title text-center">
              Results of {{\App\AcademicYear::where('academic_year',$academic_year)->first()->alias}}, {{\App\Department::find($class)->name}}
            </div>
            <div class="card-body table-responsive">
              <table class="table table-bordered text-center title">
                <thead>
                  <tr>
                    <th>Semester</th>
                    <th>Subject</th>
                    <th>N1 (50%)</th>
                    <th>N2 (50%)</th>
                    <th>AVG.</th>
                    <th>C</th>
                    <th>AVG*C</th>
                    <th>Grade</th>
                    <th>Signature</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($marks as $item)
                    <tr>
                      <td>{{ $item->semester }}</td>
                      <td>{{ $item->course_id->course_name }}</td>
                      <td>{{ $item->n1_mark }}</td>
                      <td>{{ $item->n2_mark }}</td>
                      <td>{{ ($item->n1_mark + $item->n2_mark) / 2 }}</td>
                      <td>{{ $item->course_id->coefficient }}</td>
                      <td>{{ (($item->n1_mark + $item->n2_mark) / 2) * $item->course_id->coefficient }}</td>
                      <td>{{ $item->grade }}</td>
                      <td>{{ $item->signature }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      @endif
    </div>
  </section>
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
@endsection

@extends('admin_student.master')
@section('title')
Student||Home
@endsection
@section('main')
  <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Course Page</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Course Page</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
      <!-- /.card -->
      @if(count($marks)>0)
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"></h3>
      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Course No</th>
              <th>Course Title</th>
              <th>Credit</th>
              <th>Grade</th>
            </tr>
          </thead>

          <tbody>
            <?php $res = 0; $l1t1_creditsum = 0;?>
           @foreach($marks as $mark)
           
            <tr>
              <td width="100px;">{{$mark->course_code}}</td>
              <td>{{$mark->course_name}}</td>
              <td>{{number_format((float)$credit = $mark->course_credit, 2, '.', '')}}</td>
              <td><b style="margin-left:15px;">{{trim($mark->grade_letter)}}</b></td>
              <?php $point = $mark->grade_point ?>
              <?php $res+= $credit*$point ?>
              <?php $l1t1_creditsum=$l1t1_creditsum+$credit;?>
            </tr>
            
            @endforeach
            <tr>
              <td colspan="3">Grade Point Average (GPA) for this semester :</td>
              <td><b> {{number_format((float)$l1t1_gpa=$res/$l1t1_creditsum, 2, '.', '')}}</b></td>
            </tr>
          </tbody>
        </table>
      </div>
                
        </div>
      </div>
      @else
      <center><p>No Result Found Please Select Level Term</p></center>
      @endif
    </section>
@endsection
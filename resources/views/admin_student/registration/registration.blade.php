@extends('admin_student.master')
@section('title')
Student||Registration
@endsection
@section('main')
  <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Registration Page</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Registration Page</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Courses Registration Details</h3>
              </div>
              <div class="card-body">
           
                  <div class="row" >
                    <!-- courses Registrations -->
                    <div class="col-md-6">
                        <div class="card card-primary">
                          <div class="card-header">
                              <h3 class="card-title">Courses for Spring-2019</h3>
                            </div>
                          <div class="card-body">
                              <table class="table table-striped">
                                  <tbody>
      
                                      @php
                                  $tc= 0;
      
                                      foreach($datas as $key=>$value){
                                        echo "<tr>";
                                      $c = DB::table('courses')->select('course_code','course_name','credit')->where('id','=',$value)->first();
                                        echo "<td>".$c->course_code.'-'.$c->course_name ."</td>";
                                        $tc= $tc+$c->credit;
                                        echo "</tr>";
                                       }
                                       @endphp
                                       
                                  </tbody>
                                </table>
                          </div>
                          <div class="card-footer">
                                <p>Total credit : <?php echo $tc;?></p>
                          </div>
              
                      </div>
                      

                      </div>
              

                    <div class="col-md-6">
                        <div class="card card-info">
                            <div class="card-header">
                              Total Semester Details
                            </div>
                            <div class="card-body">
                              <table class="table table-striped">
                                  <thead>
                                    <tr>
                                      <th>Fee Name</th>
                                      <th>Amount</th>
                                    </tr>
                                  </thead>

                                  <tbody>
                                      @php $total2=0; @endphp
                                      @foreach($fees as $fee)
                                      <tr>
                                        <td>{{ $fee->fee_name }}</td>
                                        <td>{{ $fee->fee_amount }}</td>
                                      </tr>
                                      @php $total2=$total2+$fee->fee_amount; @endphp
                                      @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer text-center">
                              <h5 class="text-secondary">Total  Semester Fee :-&#2547; {{ $total2 }}/-</h5>
                            </div>
                        </div>     
                    </div>
                      
                  </div><!-- /.row end -->
             
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          <!-- /.col (left) -->
     </section>
@endsection


@extends('admin_student.master')
@section('title')
Student||Registration
@endsection
@section('main')
  <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <a class="btn btn-md btn-outline-success" href="{{ URL::to('student-registration') }}">Go Back</a>&nbsp;&nbsp;
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
      <div class="container">
         
      </div>
      @if(count($datas))
      <div class="container">

      </div>
      
         <section class="content">
          <form action="{{route('student.registration')}}" method="POST">
            {{csrf_field()}}
            <div class="card card-info">
                          <div class="card-header">
                          <h3 class="card-title text-center"> Registration Details of {{ $semester }} </h3>
                          <input type="hidden" name="semester" value="{{$semester}}"/>
                          <input type="hidden" name="level" value="{{$levelTerm}}"/>
                          <input type="hidden" name="reg_type" value="{{$reg_type}}"/>
                          
                          </div>
                          <div class="card-body">
                            <h2>Level Term: {{ $levelTerm}}</h2>
                            <h2>Registration Type:
                            @if($session->reg_type==1)
                            <b>Regular/Term wise</b>
                            @elseif($session->reg_type==2)
                            <b>Term Repeat</b>
                            @elseif($session->reg_type==3)
                            <b>Referred</b>
                            @elseif($session->reg_type==4)
                            <b>Improvement</b>
                            @elseif($session->reg_type==5)
                            <b>Backlog</b>
                            @elseif($session->reg_type==6)
                            <b>Retake</b>
                            @endif
                            </h2>
                            <table class="table table-striped">
                              <thead>
                                <tr>
                                  <th>Course Code</th>
                                  <th>Course Name</th>
                                </tr>
                              </thead>
                              <tbody>
                                  @php
                                  $tc= 0;
                                  @endphp
                                  @foreach ($datas as $key=>$course_id)
                                  <input type="hidden" name="course_id[{{$key}}]" value="{{$course_id}}"/>
                                  <tr>
                                    @php
                                     $course= DB::table('courses')->select('course_code','course_name','credit')->where('id',$course_id)->first();  
                                    @endphp
                                    <td>{{ $course->course_code }}</td>
                                    <td>{{ $course->course_name }}</td>
                                    @php $tc= $tc+$course->credit; @endphp
                                  </tr>
                                  @endforeach
                              </tbody>
                            </table>
                        
                          </div>
                          <!-- /.card-body -->
                          <div class="card-footer">
                              <p class="text-center text-secondary"><b>You have taken Total: <?php echo $tc;?> credit  in this semester.</b></p>
                        
                            <br>
                            <div class="row">
                              <div class="col-md-1"><input type="checkbox" id="confirm" style="height:20px;width:20px;" name="confirm"  class="form-control"></div>
                              @if ($errors->has('course_id'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('course_id') }}</strong>
                        </span>
                        @endif
                              <div class="col-md-7">
                                <p> I have read everything carefully and I want to confirm my registration.</p>
                              </div>
                              <div class="col-md-4">
                                <button  type="submit" id="submit" class="btn btn-success"><i class="fa fa-check " style="font-size:20px"></i> Submit Confirmed</button>
                              </div>
                            </div>
                            </div>
                        </div>
                        <!-- /.card -->
          </form>
                      </div>
                      <!-- /.col (left) -->
        </section>
        @endif
   
@endsection

@section('extrascript')
<script>
   $(document).ready(function() {
     $(':button[type="submit"]').prop('disabled', true);

     
     $('input[type="checkbox"]').on('change',function() {
      
        if($('#confirm').is(':checked')) {
         // alert(id);
           $(':button[type="submit"]').prop('disabled', false);
        }else{
          $(':button[type="submit"]').prop('disabled', true);
        }
          
     });
 });
   </script>
 

@endsection
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
  
      <div class="container-fluid">
          <div class="row">
                <div class="col-md-12 alert alert-danger">
                    To make any correction please Contact with your <b>Head of The Department/ Batch co-ordinator.</b>  
                </div>
              <div class="col-md-3">
                <ul class="list-group">
                    @foreach($sessions as $session)  
                    <a href='{{url("/student-show_registration/$session->semester/$session->reg_type")}}'>
                        <li class="list-group-item">{{$session->semester}} || 
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
                    </li></a>
                    @endforeach
                </ul>
              </div>
              @if(count($reg_students))
              <div class="col-md-9">
                  <section class="content">
                      <div class="card card-info">
                                    <div class="card-header">
                                      <h3 class="card-title text-center"> Registration Details of {{ $semester }}(
                                          @if($reg_type==1)
                                            <b>Regular/Term wise</b>
                                            @elseif($reg_type==2)
                                            <b>Term Repeat</b>
                                            @elseif($reg_type==3)
                                            <b>Referred</b>
                                            @elseif($reg_type==4)
                                            <b>Improvement</b>
                                            @elseif($reg_type==5)
                                            <b>Backlog</b>
                                            @elseif($reg_type==6)
                                            <b>Retake</b>
                                            @endif

                                      )</h3>
                                    </div>
                                    <div class="card-body">
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
                                            @foreach ($reg_students as $course)
                                            <tr>
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
                                        <p class="text-center text-secondary">You have taken Total:   <?php echo $tc;?> credit  in this semester.</p>
                                  </div>
                                  </div>
                                  <!-- /.card -->
          
                                </div>
                                <!-- /.col (left) --> 
                  </section>
              </div>
              @endif
          </div>
      </div>
      

        
   
@endsection

@section('extrascript')
<script>
   $(document).ready(function() {
     $('#level').on('change',function (){
                 var level= $('#level').val();
                 //alert(level);
                if(!level){
                 new PNotify({
                     title: 'Validation Error!',
                     text: 'Please Pic A Level!',
                     type: 'error',
                     styling: 'bootstrap3'
                 });
             }
             else {
                     //for subjects
                     $.ajax({
                         url:'/student-course/'+level,
                         type: 'get',
                         dataType: 'json',
                         success: function(data) {
                            // alert(data);
                             console.log(data);
                             var res='';
                            //$('#student_id').empty();
                             $('#course').append('<option  value="">Pic Courses</option>');
                             $.each(data, function(key, value) {
                                 
                                 res +=
                                 '<option value="'+value.id+'">'+value.course_code+'['+value.course_name+']</option>';
                             });
                             $('#course').html(res);
                            
 
                         },
                         error: function(data){
                             console.log(data);
                             var respone = JSON.parse(data.responseText);
                             $.each(respone.message, function( key, value ) {
                                 new PNotify({
                                     title: 'Error!',
                                     text: value,
                                     type: 'error',
                                     styling: 'bootstrap3'
                                 });
                             });
                         }
                     });
                 }
     });
   });
   </script>
 

@endsection
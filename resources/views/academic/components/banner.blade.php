  {{--School information  --}}
  <div class="col-lg-4 col-md-4 col-sm-4">
    @foreach (config('constant.report_card_left') as $item)
      <span>{{$item}}</span> <br>
    @endforeach
      <span>{{env('APP_NAME')}}</span> <br>
  </div>
  <div class="col-lg-4 col-md-4 col-sm-4 text-center">
    <img src="{{ asset('/images/main_logo.png') }}" alt="main-logo" height="200" width="200" style="margin-top:-2%">
  </div>
  <div class="col-lg-4 col-md-4 col-sm-4">
    @foreach (config('constant.report_card_right') as $item)
      <span>{{$item}}</span> <br>
    @endforeach
    <span>{{env('APP_NAME')}}</span> <br>
  </div>
  {{-- Heading and Semester Title --}}
  <div class="col-md-12">
    <h1 class="text-center px-3 pt-3">
      @if ($semester == config('constant.sem1'))
        {{ config('constant.heading1') }}
      @elseif($semester == config('constant.sem2'))
        {{ config('constant.heading2') }}
      @elseif($semester == config('constant.sem3'))
        {{ config('constant.heading3') }}
      @else
        {{ config('constant.annual_heading') }}
      @endif
    </h1>
    <h5 class="text-center">
      School Year: @if ($semester == config('constant.annual'))
        {{\App\AcademicYear::where('academic_year',$annual_grades[0]['academic_year'])->first()->alias}}
      @else
        {{\App\AcademicYear::where('academic_year',$marks->first()->academic_year)->first()->alias}}
      @endif
    </h5>
  </div>
  {{-- image --}}
  <div class="col-lg-2 col-md-2 col-sm-2">
    <img src="{{ asset(config('constant.asset_url') . 'student_images/' . $student->image) }}" width="150" height="150" class="profile-image">
  </div>
  {{-- Personal Info --}}
  <div class="col-lg-10 col-md-10 col-sm-10">
    <table class="table table-bordered">
      <tr>
          <th>Student’s Name</th>
          <td>{{$student->name}}</td>
          <th>Class</th>
          <td>{{$class->name}}</td>
      </tr>
      <tr>
          <th>Gender</th>
          <td>{{strtoupper($student->gender)}}</td>
          <th>Repeater</th>
          <td>{{strtoupper($student->repeater)}}</td>
      </tr>
      <tr>
          <th>DOB</th>
          <td>{{Carbon::parse($student->dob)->format('d M Y')}}</td>
          <th>Enrolment</th>
          <td>{{Carbon::parse($student->admission_date)->format('d M Y')}}</td>
      </tr>
      <tr>
          <th>Matricule</th>
          <td>{{$student->student_id}}</td>
          <th>No. of subjects</th>
          <td></td>
      </tr>
      <tr>
          <th>Parent’s Name</th>
          <td>{{$student->legal_guidance}}</td>
          <th>No. of subjects passed</th>
          @if ($semester != config('constant.annual'))
            <td>{{$marks->where('grade', '!=', 'D')->count()}}</td>
          @else
            <td>
              {{count(array_filter($annual_grades, function ($item) {
                  return $item['remark'] != 'D';
                }))}}
            </td>
          @endif
      </tr>
      <tr>
          <th>Parent’s Contact</th>
          <td>{{$student->guidance_phone}}</td>
          <th>Class master</th>
          <td>{{$additional_data['class_master']}}</td>
      </tr>
    </table>
  </div>
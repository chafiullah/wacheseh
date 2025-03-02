@extends('layouts.master')

@section('title', 'Program Outline')

@section('content')
  <!-- page content -->
  <div class="right_col" role="main">
    <div class="">
      <div class="row">
        <div class="col-md-12">
          <div class="x_panel">
            <div class="x_title">
              <h4 class="text-success">I forgot what to do here!</h4>
              <p>Well, you are here to update the outline name. So, if you really want to do that change the current name and select class and then press update. Remember the system automatically ignores duplicate data, so you have nothing to worry about! But if you are here for something else then check the sections below, you don't have to do anything here. </p>
            </div>
            {{-- department wise students --}}
            <div class="x_content">
              <form action="{{ route('programs.outline.patch',$outline->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="form-row">
                  <div class="col-md-6">
                    <label for="">Outline Name:</label>
                    <input type="text" name="name" class="form-control" value="{{$outline->name}}" required>
                  </div>
                  <div class="col-md-6">
                    <label for="">Class to apply the Outline:</label>
                    <select name="class_id" class="form-control">
                      @foreach($departments as $department)
                        <option value="{{$department->id}}" @if ($department->id == $outline->class_id)
                            selected
                        @endif>{{$department->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-md-12" style="margin-top: 10px">
                    <button type="submit" class="btn btn-success btn-md pull-right">update</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="x_panel">
            <div class="x_title">
              <h4 class="text-success">How this works?</h4>
              <p>It's simple. The selected courses are 'checked' as you can see. If you don't see any course checked that means this outline is fresh and you have to assign courses to it. If you want to modify the ouline: simply uncheck the courses and check the new courses and update.</p>
            </div>
            <div class="x_content">
              <form action="{{route('programsoutline.subjects',$outline->id)}}" method="post" enctype="multipart/form-data">
              @csrf
              @method('PATCH')
                <div class="form-row">
                  <div class="col-sm-12 col-md-12 form-group">
                    <label for="">Adding Courses To:</label>
                    <input type="text" class="form-control" value="{{$outline->name}}" readonly>
                  </div>
                  <div class="col-sm-12 col-md-12 form-group">
                    <label>Select Courses To Add:</label>
                    <br>
                    <ul>
                      @foreach ($courses as $course)
                      <li> <div class="checkbox-inline">
                       <label><input type="checkbox" name="courses[]" value="{{$course->id}}" @if (in_array($course->id,$outline->outlinecourses->pluck('course_id')->toArray()))
                         checked
                       @endif>
                         {{$course->name .' | coeff. : '.$course->coefficient }}</label>
                     </div></li>
                     @endforeach
                    </ul>
                  </div>
                  <div class="col-sm-12 col-md-12 form-group">
                    <button type="submit" class="btn btn-success pull-right">Update</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="x_panel">
            <div class="x_title">
              <h4 class="text-success">How this works?</h4>
              <p>The program outline you are working with is already selected. So, in this section you simply select the academic years you want this outline to be assigned. Let's say you want this outline to be assigned for students of Form One who are/were in academic year 23/24, 24/25, 25/26 and so on. So, you select those academic years and leave the rest as it is and press update. Now lets say you don't want academic year 25/26 to be in the list, what should you do? You simply unselect that academic year and keep the academic years you want to keep selected and then update.</p>
              <small class="text-success">The selected academic years will be colored 'gray' or 'blue' in the list based on your browser.</small>
            </div>
            <div class="x_content">
              <form action="{{route('programsoutline.years',$outline->id)}}" method="post" enctype="multipart/form-data">
              @csrf
              @method('patch')
                <div class="form-row">
                  <div class="col-sm-12 col-md-12 form-group">
                    <label for="">Add academic years to this syllabus:</label>
                    <select name="academic_years[]" class="form-control" multiple>
                      @foreach ($academic_years as $year)
                          <option value="{{$year->id}}" @if (in_array($year->id,$outline_years))
                              selected
                          @endif>{{$year->alias}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-sm-12 col-md-12 form-group">
                    <button type="submit" class="btn btn-success pull-right">Update</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /page content -->
@endsection

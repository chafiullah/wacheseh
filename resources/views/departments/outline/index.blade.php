@extends('layouts.master')

@section('title', 'Program Outline')

@section('content')
  <!-- page content -->
  <div class="right_col" role="main">
    <div class="">
      <div class="row">
        <div class="col-md-12">
          <div class="x_panel">
            {{-- department wise students --}}
            <div class="x_title">
              <h4 class="text text-success">How this works?</h4>
              <ol>
                <li>This is the module where you will define what courses a class will study for one academic year. Let's make an example: in the academic year 2024/2025 Form One will study Math, Science, English, etc. So we will create a outline as 'FormOnev1' later we will add the courses in 'FormOnev1' and after that we will attach that outline to a specfic academic year. If the outline doesn't change next year then you can simply attach it again for the next academic year. No need to make another one!</li>
                <li>
                  Now I want to add courses to this Outline! Sure, lets click the 'edit' button and get inside.
                </li>
                <li>
                  I made a mistake while creating a Outline now I want to delete it. Sure, but try editing it first, if it solves your problem then congratualtions! If not you can delete it using the 'red' button but the button is visible only if you have certain permission.
                </li>
                <li class="text-danger">
                  But an outline is connected to student grades, which means if you delete one outline as a whole from here, it will automatically remove the courses from student's grade book and you won't be able to generate spreadsheets to upload grades. So, be very careful before you delete an outline from where. The system suggests you re-check everything and then proceed.
                </li>
              </ol>
              <div class="clearfix"></div>
              @permission('add-subject')
                <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target=".bd-example-modal-lg" style="margin-top: 15px">Create New</button>
              @endpermission
            </div>
            <div class="x_content table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Class</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($outlines as $outline)
                      <tr>
                        <td>{{$outline->name}}</td>
                        <td>{{$outline->department->name}}</td>
                        <td>
                          @permission('add-subject')
                          <a href="{{ route('programs.outline.edit', $outline->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                          <a href="{{ route('programs.outline.destroy', $outline->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to remove this item?')"><i
                            class="fas fa-trash"></i></a>
                          @endpermission
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
  //modal
  <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-content">
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_content">
                    <form action="{{ route('programs.outline.store') }}" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="form-row">
                        <div class="col-md-6">
                          <label for="">Outline Name:</label>
                          <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                          <label for="">Outline Name:</label>
                          <select name="class_id" class="form-control">
                            @foreach($departments as $department)
                              <option value="{{$department->id}}">{{$department->name}}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="col-md-12" style="margin-top: 10px">
                          <button type="submit" class="btn btn-success btn-md pull-right">submit</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <!-- /page content -->
@endsection

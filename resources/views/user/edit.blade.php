@extends('layouts.master')

@section('title', 'User-edit')

@section('extrastyle')
  <link href="{{ URL::asset('assets/css/select2.min.css') }}" rel="stylesheet">
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
              <h2>User<small> User basic information.</small></h2>

              <div class="clearfix"></div>
            </div>

            <div class="x_content">
              <form class="form-horizontal form-label-left" novalidate method="post" action="{{ URL::route('user.update', $user->id) }}">
                @csrf
                @method('PATCH')
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label" for="firstname"> Name <span class="required">*</span>
                      </label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-info blue"></i></span>
                        <input id="name" type="text" class="form-control" name="name" value="{{ $user->name }}"required="required">
                      </div>
                      <span class="text-danger">{{ $errors->first('name') }}</span>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label" for="email">Email:</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-envelope blue"></i></span>
                        <input type="text" id="email" name="email" class="form-control" value="{{ $user->email }}">
                      </div>
                      <span class="text-danger">{{ $errors->first('email') }}</span>

                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label" for="password">Password</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-key blue" aria-hidden="true"></i></span>
                        <input id="name" class="form-control" name="password" type="password">
                      </div>
                      <small class="text-bold text-danger">If you want to reset the password then put a new one or leave it blank</small>
                      <span class="text-danger">{{ $errors->first('password') }}</span>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label" for="confirmpassword">Status<span class="required">*</span>
                      </label>
                      <select name="status" class="form-control">
                        <option value="active">active</option>
                        <option value="inactive">inactive</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label" for="confirmpassword">Phone Number:<span class="required">*</span>
                      </label>
                      <input id="phone" class="form-control"  name="phone" value="{{ $user->phone }}" type="text">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label" for="confirmpassword">Subject/Position<span class="required">*</span>
                      </label>
                      <input id="subject_position" class="form-control"  name="subject_position" value="{{ $user->subject_position }}" type="text">
                    </div>
                  </div>
                  <div class="col-md-12 form-group">
                    <button type="submit" class="btn btn-primary btn-attend"><i class="fa fa-plus"></i> Save </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- row end -->
        <div class="clearfix"></div>

      </div>
    </div>
    <!-- /page content -->
  @endsection

  @section('extrascript')
    <!-- dataTables -->
    <script src="{{ URL::asset('assets/js/select2.full.min.js') }}"></script>
    <script>
      $(document).ready(function() {
        $(".select2").select2({
          placeholder: "Select Faculty",
          allowClear: true
        });
      });
    </script>
  @endsection

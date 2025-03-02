@extends('layouts.master')

@section('title', 'User')

@section('extrastyle')
    <link href="{{ URL::asset('assets/css/select2.min.css')}}" rel="stylesheet">
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
                    <form class="form-horizontal form-label-left" novalidate method="post" action="{{URL::route('user.store')}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                      <label class="control-label" for="firstname"> Name <span class="required">*</span>
                                      </label>
                                      <div class="input-group">
                                          <span class="input-group-addon"><i class="fa fa-info blue"></i></span>
                                          <input id="name" type="text" class="form-control"  name="name" value="" placeholder="Enter a Name" required="required">
                                      </div>
                                      <span class="text-danger">{{ $errors->first('name') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                      <label class="control-label" for="email">Email
                                      </label>
                                      <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-envelope blue"></i></span>
                                        <input type="text" id="email" name="email" placeholder="example@baiust.com"  class="form-control">
                                      </div>
                                      <span class="text-danger">{{ $errors->first('email') }}</span>
        
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                      <label class="control-label" for="password">Password<span class="required">*</span>
                                      </label>
                                      <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-key blue"></i></span>
                                        <input id="name" class="form-control"  name="password" value="" type="password">
                                      </div>
                                      <span class="text-danger">{{ $errors->first('password') }}</span>
                                    </div>
                                 </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                      <label class="control-label" for="confirmpassword">Confirm Password<span class="required">*</span>
                                      </label>
                                      <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-key blue"></i></span>
                                        <input type="password" class="form-control"  name="password_confirmation" value="" required="required">
                                      </div>
                                      <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
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
                                      <input id="phone" class="form-control"  name="phone" value="" type="text">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                      <label class="control-label" for="confirmpassword">Subject/Position<span class="required">*</span>
                                      </label>
                                      <input id="subject_position" class="form-control"  name="subject_position" value="" type="text">
                                    </div>
                                </div>
                                <div class="col-md-12 form-group">
                                     <button type="submit" class="btn btn-primary btn-attend"><i class="fa fa-plus"></i> Save </button>
                                </div>
                            </div>
                      </form>
                  </div>
                </div>
                <div class="x_panel">
                  <div class="x_title">
                  <h3>Download the format from <b><u><a href="{{ asset('/public/ExcelFormats/UserImportSample.xlsx') }}" download>here</a></u></b></h3>
                  <h4 class="text-danger">No field should be empty in your spreadsheet!!</h4>
                  </div>
                  <div class="x_content">
                    <form action="{{ route('user.import') }}" method="post" enctype="multipart/form-data">
                      @csrf()
                      <div class="form-row">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                          <div class="form-group">
                            <label for="">Upload Users</label>
                            <input type="file" name="file" class="form-control" required>
                          </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-12">
                          <button type="submit" class="btn btn-success pull-right">Upload</button>
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
    <script src="{{ URL::asset('assets/js/select2.full.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            $(".select2").select2({
                placeholder: "Select Faculty",
                allowClear:true
            });
        });
    </script>
@endsection

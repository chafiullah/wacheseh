@extends('layouts.master')

@section('content')
  <!-- page content -->
  <div class="right_col" role="main">
    <div class="">
      <div class="clearfix"></div>
      <!-- row start -->
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_content">
              <h4 class="text-info">Make Sure:</h4>
              <ul class="text-danger">
                <li>Admission date followed the format mm/dd/yyyy but remove the <b>mm/dd/yyyy</b> portion from the headline before you upload it</li>
                <li>Date of Birth followed the format mm/dd/yyyy but remove the <b>mm/dd/yyyy</b> portion from the headline before you upload it</li>
                <li>Both of these dates are converted to 'text'</li>
                <li>Class IDs, Region IDs are accorded</li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Import new students from excel file</h2>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <h3>Download the format from <b><u><a href="{{ asset('/public/ExcelFormats/StudentImportFormat.xlsx') }}" download>here</a></u></b></h3>
              <form method="POST" action="{{ route('student.import') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="file">File: <span class="text-danger">*</span></label>
                    <input type="file" id="file" required="required" class="form-control has-feedback-left" name="file">
                    <i class="fa fa-file-image-o form-control-feedback left" aria-hidden="true"></i>
                    <span id="msg_file" class="text-danger">{{ $errors->first('file') }}</span>
                  </div>
                  <div class="form-group col-md-12">
                    <button type="submit" class="btn btn-primary pull-right">Submit</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_content">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>{{ config('constant.active') }}</td>
                  </tr>
                  <tr>
                    <td>{{ config('constant.withdrawn') }}</td>
                  </tr>
                  <tr>
                    <td>{{ config('constant.expelled') }}</td>
                  </tr>
                  <tr>
                    <td>{{ config('constant.alumni') }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_content">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Database ID</th>
                    <th>Region Name</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($regions as $item)
                    <tr>
                      <td>{{ $item->id }}</td>
                      <td>{{ $item->name }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- row end -->
      <div class="clearfix"></div>
    </div>
  </div>
  <!-- /page content -->
@endsection

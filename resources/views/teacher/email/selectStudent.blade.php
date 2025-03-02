@extends('layouts.master')

@section('title', 'Send Custom Emails')

@section('extrastyle')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection

@section('content')
  <!-- page content -->
  <div class="right_col" role="main">
    <div class="">
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-12">
          <div class="x_panel">
            {{-- department wise students --}}
            <div class="x_title">
              <h2>Students:</small></h2>
              <div class="clearfix"></div>
            </div>

            <div class="x_content">
              <form action="{{ route('send.mail.send') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="">Select Student/s:</label>
                    <select name="studentIDs[]" class="form-control select2" multiple>
                      <option></option>
                      @foreach ($student_list as $student)
                        <option value="{{ $student['studentID'] }}">{{ $student['studentID'] . ' - ' . $student['firstName'] . ' - ' . $student['lastName'] }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-md-12">
                    <label for="">Subject:</label>
                    <input type="text" name="subject" id="" class="form-control" placeholder="" aria-describedby="helpId">
                  </div>

                  <div class="form-group col-md-12">
                    <label for="">Body:</label>
                    <textarea name="body" class="summernote form-control"></textarea>
                  </div>
                  <div class="form-group col-md-12">
                    <button type="submit" class="btn btn-success pull-right"><i class="fas fa-paper-plane    "></i> send mail</button>
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

@section('extrascript')
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
  <script>
    $(document).ready(function() {
      $('.select2').select2({
        placeholder: 'select student/s',
        allowClear: true
      });
      $('.summernote').summernote({
        placeholder: 'Email Body Here...',
        tabsize: 2,
        height: 200
      });
    });
  </script>
@endsection

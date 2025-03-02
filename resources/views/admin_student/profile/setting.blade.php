@extends('admin_student.master')
@section('title')
  Student || Profile Settings
@endsection
@section('main')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12 mt-3">
        <div class="card">
          <div class="card-header">
            Information Update:
          </div>
          <div class="card-body">
            <form action="{{ route('student.profile.update', $student->id) }}" method="post" enctype="multipart/form-data">
              @csrf
              @method('PATCH')
              <div class="form-row">
                <input type="hidden" name="task_for" value="information_change">
                <div class="form-group col-md-6">
                  <label for="">Student Email:</label>
                  <input type="email" name="email" class="form-control" value="{{ $student->email }}" required>
                </div>
                <div class="form-group col-md-6">
                  <label for="">Legal Guardian Email:</label>
                  <input type="email" name="guidance_email" class="form-control" value="{{ $student->guidance_email }}" required>
                </div>
                <div class="form-group col-md-12">
                  <label for="">Address:</label>
                  <input type="text" name="address" class="form-control" value="{{ $student->address }}" required>
                </div>
                <div class="col-md-4">
                  <label for="">Student Image:</label>
                  <input type="file" class="form-control" name="image" required>
                </div>
                <div class="col-md-4">
                  <label for="">Student Previous Report Card:</label>
                  <input type="file" class="form-control" name="report_card" required>
                </div>
                <div class="col-md-4">
                  <label for="">Student Birth Certificate:</label>
                  <input type="file" class="form-control" name="birth_certificate" required>
                </div>
                <div class="form-group col-md-12">
                  <label for="">Enter Your Password to Continue:</label>
                  <input type="password" class="form-control" name="password_to_update" id="password_to_update">
                </div>
                <div class="form-group col-md-12 d-none" id="update_profile_button">
                  <button type="submit" class="btn btn-success float-right">update</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      {{-- to change the password only --}}
      <div class="col-md-12 mt-3">
        <div class="card">
          <div class="card-header">
            Password Update:
          </div>
          <div class="card-body">
            <form action="{{ route('student.profile.update', $student->id) }}" method="post" enctype="multipart/form-data">
              @csrf
              @method('PATCH')
              <div class="form-row">
                <input type="hidden" name="task_for" value="password_change">
                <div class="form-group col-md-4">
                  <label for="">Current Password:</label>
                  <input type="password" class="form-control" name="current_password" id="current_password" required>
                </div>
                <div class="form-group col-md-4">
                  <label for="">New Password:</label>
                  <input type="password" class="form-control" name="password" id="password" required>
                </div>
                <div class="form-group col-md-4">
                  <label for="">Confirm Password:</label>
                  <input type="password" class="form-control" name="confirm_password" id="confirm_password" required>
                  <small class="text-danger" id="password_match_message">Password did not match!</small>
                </div>
                <div class="form-group col-md-12 d-none" id="update_password_button">
                  <button type="submit" class="btn btn-success float-right">update</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('extrascript')
  <script>
    // profile update action
    $("#password_to_update").keyup(function(e) {
      try {
        let submit_button_object = $("#update_profile_button");
        let password_to_update_object = $("#password_to_update");
        if (password_to_update_object.val() === '') {
          submit_button_object.addClass('d-none');
        } else {
          submit_button_object.removeClass('d-none');
        }
      } catch (error) {
        console.log(error);
      }
    });


    // password change action
    $("#confirm_password").on("keyup", function() {
      let password = $("#password").val();
      let confirm_password = $("#confirm_password").val();
      let message_object = $("#password_match_message");
      let submit_button_object = $("#update_password_button");
      if (password === confirm_password) {
        // $(selector).removeClass(className);
        message_object.removeClass('text-danger');
        message_object.addClass('text-success');
        message_object.html('Password Matched.');
        submit_button_object.removeClass('d-none');
      } else {
        message_object.removeClass('text-success');
        message_object.addClass('text-danger');
        message_object.html('Password did not match!');
        submit_button_object.addClass('d-none');
      }
    });
  </script>
@endsection

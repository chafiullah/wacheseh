<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" href="{{ asset('assets/images/main_logo.png') }}" type="image/x-icon">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('login_pages/student_page/fonts/icomoon/style.css') }}">
  <link rel="stylesheet" href="{{ asset('login_pages/student_page/css/owl.carousel.min.css') }}">
  <link rel="stylesheet" href="{{ asset('login_pages/student_page/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('login_pages/student_page/css/style.css') }}">
  @toastr_css
  <title>Password Reset</title>

</head>

<body>
  <div class="content">
    <div class="container">
      <div class="row">
        <div class="col-md-12 text-center">
          <img src="{{ asset('assets/images/main_logo.png') }}" alt="no-image" height="150" width="150">
          <h3>Reset Password</h3>
        </div>
        <div class="col-md-12">
          <form action="{{ route('password.reset.update', [$user, decrypt($user_id)]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="form-row">
              <div class="form-group col-md-12 mb-3">
                <label for="">New Password:</label>
                <input type="password" name="password" class="form-control" required>
              </div>
              <div class="form-group col-md-12 mb-3">
                <label for="">Password Confirm:</label>
                <input type="password" name="password_confirm" class="form-control" required>
              </div>
            </div>
            <div class="col-md-12 mb-3">
              <button type="submit" class="btn btn-success btn-md float-right">update</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script src="{{ asset('login_pages/student_page/js/jquery-3.3.1.min.js') }}"></script>
  <script src="{{ asset('login_pages/student_page/js/popper.min.js') }}"></script>
  <script src="{{ asset('login_pages/student_page/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('login_pages/student_page/js/main.js') }}"></script>
  @toastr_js
  @toastr_render
</body>

</html>

<!doctype html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" href="https://admission.baiust.edu.bd/frontend/icons/logo.png" type="image/x-icon">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('login_pages/student_page/fonts/icomoon/style.css') }}">
  <link rel="stylesheet" href="{{ asset('login_pages/student_page/css/owl.carousel.min.css') }}">

  <link rel="stylesheet" href="{{ asset('login_pages/student_page/css/bootstrap.min.css') }}">

  <link rel="stylesheet" href="{{ asset('login_pages/student_page/css/style.css') }}">
  <title>IUMSS | Student Portal</title>
</head>

<body>
  <div class="content">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <img src="{{ asset('login_pages/student_page/images/undraw_remotely_2j6y.svg') }}" alt="Image" class="img-fluid">
        </div>
        <div class="col-md-6 contents">
          <div class="row justify-content-center">
            <div class="col-md-8">
              <div class="mb-4">
                <h3>Sign In</h3>
                <p class="mb-4">Lorem ipsum dolor sit amet elit. Sapiente sit aut eos consectetur adipisicing.</p>
              </div>
              <form action="{{ URL::to('student-login') }}" method="post">
                @csrf
                <div class="form-group first">
                  <label for="username">Student ID:</label>
                  <input type="text" class="form-control" name="student_id" required>
                </div>
                <div class="form-group last mb-4">
                  <label for="password">Password</label>
                  <input type="password" class="form-control" name="password" id="password">
                </div>
                <div class="d-flex mb-5 align-items-center">
                  <label class="control control--checkbox mb-0"><span class="caption">Remember me</span>
                    <input type="checkbox" checked="checked" />
                    <div class="control__indicator"></div>
                  </label>
                  <span class="ml-auto"><a href="#" class="forgot-pass">Forgot Password</a></span>
                </div>
                <input type="submit" value="Log In" class="btn btn-block btn-primary">
                <span class="d-block text-left my-4 text-muted">&mdash; or login with &mdash;</span>
                <div class="social-login">
                  <a href="#" class="facebook">
                    <span class="icon-facebook mr-3"></span>
                  </a>
                  <a href="#" class="twitter">
                    <span class="icon-twitter mr-3"></span>
                  </a>
                  <a href="#" class="google">
                    <span class="icon-google mr-3"></span>
                  </a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="{{ asset('login_pages/student_page/js/jquery-3.3.1.min.js') }}"></script>
  <script src="{{ asset('login_pages/student_page/js/popper.min.js') }}"></script>
  <script src="{{ asset('login_pages/student_page/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('login_pages/student_page/js/main.js') }}"></script>
</body>

</html>

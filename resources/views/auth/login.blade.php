<!DOCTYPE html>
<html>

<head>
  <!-- Basic Page Info -->
  <meta charset="utf-8">
  <title>{{ env('APP_NAME') }}</title>

  <link rel="icon" type="image/x-icon" href="{{ asset('/images/main_logo.png') }}">

  <!-- Mobile Specific Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <!-- CSS -->
  <link rel="stylesheet" type="text/css" href="{{ asset('login_pages/admin_page/styles/core.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('login_pages/admin_page/styles/icon-font.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('login_pages/admin_page/styles/style.css') }}">
  @toastr_css
  <style>
    @media (max-width:600px) {
      #admin-login-image {
        display: none;
      }
    }
  </style>
</head>

<body class="login-page">
  <div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-12 col-12">
          @if ($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
        </div>
        <div class="col-md-6 col-lg-7 text-center" id="admin-login-image">
          <img src="{{ asset('images/main_logo.png') }}" alt="admin-login-image" style="height: 200px">
        </div>
        <div class="col-md-6 col-lg-5 col-sm-12">
          <div class="login-box bg-white box-shadow border-radius-10">
            <div class="login-title text-center">
              <img src="{{ asset('images/wacheseh_logo.png') }}" alt="main-logo" class="mb-3 p-5">
            </div>
            <form action="{{ route('login') }}" method="post" enctype="multipart/form-data">
              @csrf
              <div class="input-group custom">
                <div class="input-group-prepend custom">
                  <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                </div>
                <input type="text" class="form-control form-control-lg" placeholder="Username" name="email">
              </div>
              <div class="input-group custom">
                <div class="input-group-prepend custom">
                  <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                </div>
                <input type="password" class="form-control form-control-lg" placeholder="**********" name="password">
              </div>
              <div class="input-group custom">
                <a href="#" class="forgot-pass text-danger" data-toggle="modal" data-target="#exampleModal">Forgot Password?</a>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <div class="input-group mb-0">
                    <button class="btn btn-primary btn-lg btn-block" type="submit">Sign In</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-danger" id="exampleModalLabel">Reset Password</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route('send.otp') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="">Your Email:</label>
                <input type="email" name="email" class="form-control" placeholder="user@example.com" aria-describedby="helpId">
                <input type="hidden" name="user_type" value="admin">
              </div>
              <div class="form-group col-md-12">
                <button type="submit" class="btn btn-success float-right">submit</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- js -->
  <script src="login_pages/admin_page/scripts/core.js"></script>
  <script src="login_pages/admin_page/scripts/script.min.js"></script>
  <script src="login_pages/admin_page/scripts/process.js"></script>
  <script src="login_pages/admin_page/scripts/layout-settings.js"></script>
  @toastr_js
  @toastr_render
</body>

</html>

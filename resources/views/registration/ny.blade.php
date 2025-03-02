<!DOCTYPE html>
<html lang="en">

<head>
  <link href="https://fonts.googleapis.com/css2?family=Roboto" rel="stylesheet">
  <style>
    .container,
    .container-fluid,
    .container-sm,
    .container-md,
    .container-lg,
    .container-xl {
      width: 100%;
      padding-right: 15px;
      padding-left: 15px;
      margin-right: auto;
      margin-left: auto;
    }

    .row {
      display: -ms-flexbox;
      display: flex;
      -ms-flex-wrap: wrap;
      flex-wrap: wrap;
      margin-right: -15px;
      margin-left: -15px;
    }

    .col-1,
    .col-2,
    .col-3,
    .col-4,
    .col-5,
    .col-6,
    .col-7,
    .col-8,
    .col-9,
    .col-10,
    .col-11,
    .col-12,
    .col,
    .col-auto,
    .col-sm-1,
    .col-sm-2,
    .col-sm-3,
    .col-sm-4,
    .col-sm-5,
    .col-sm-6,
    .col-sm-7,
    .col-sm-8,
    .col-sm-9,
    .col-sm-10,
    .col-sm-11,
    .col-sm-12,
    .col-sm,
    .col-sm-auto,
    .col-md-1,
    .col-md-2,
    .col-md-3,
    .col-md-4,
    .col-md-5,
    .col-md-6,
    .col-md-7,
    .col-md-8,
    .col-md-9,
    .col-md-10,
    .col-md-11,
    .col-md-12,
    .col-md,
    .col-md-auto,
    .col-lg-1,
    .col-lg-2,
    .col-lg-3,
    .col-lg-4,
    .col-lg-5,
    .col-lg-6,
    .col-lg-7,
    .col-lg-8,
    .col-lg-9,
    .col-lg-10,
    .col-lg-11,
    .col-lg-12,
    .col-lg,
    .col-lg-auto,
    .col-xl-1,
    .col-xl-2,
    .col-xl-3,
    .col-xl-4,
    .col-xl-5,
    .col-xl-6,
    .col-xl-7,
    .col-xl-8,
    .col-xl-9,
    .col-xl-10,
    .col-xl-11,
    .col-xl-12,
    .col-xl,
    .col-xl-auto {
      position: relative;
      width: 100%;
      padding-right: 15px;
      padding-left: 15px;
    }

    .text-center {
      text-align: center !important;
    }

    span {
      font-size: 10px;
      font-weight: bold;
      position: absolute;
      z-index: 9999;
      font-family: 'Roboto', sans-serif;
    }

  </style>
</head>

<body>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <span style="margin: 9.5% 0% 0% 24%">{{ $details->firstName . ' ' . $details->middleName . ' ' . $details->lastName }}</span>
        <span style="margin: 21% 0% 0% 45%">State of Florida</span>
        <span style="margin: 16.5% 0% 0% 73.5%">{{ $graduation_date->format('m') }}</span>
        <span style="margin: 16.5% 0% 0% 78%">{{ $graduation_date->format('d') }}</span>
        <span style="margin: 16.5% 0% 0% 81.5%">{{ $graduation_date->format('Y') }}</span>
      </div>
      <div class="col-md-12 text-center" style="z-index: -1">
        <img class="img-fluid" src="{{ public_path('ny/ny-form.jpg') }}" style="width: 95%">
      </div>
      <div class="col-md-12">
        <img src="{{ public_path('ny/signature.png') }}" height="50" width="150" alt="no-signature-found" style="margin: 46% 0 0 10%; position: absolute;">
      </div>
    </div>
  </div>
</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Student Infomation</title>
  <link rel="stylesheet" href="{{ asset('transcript/dist/css/bootstrap.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat" rel="stylesheet">
  <style>
    * {
      font-family: 'Montserrat', sans-serif;
      font-weight: 300;
    }

    h3 {
      font-family: monospace;
      font-size: 30px;
    }

    p {
      font-size: 25px;
      line-height: .75;
    }

    .table th,
    .table td {
      padding: .45rem !important;
      vertical-align: top;
      border-top: 1px solid #dee2e6;
    }

  </style>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-md-12 text-center">
        <img src="{{ asset('assets/images/main_logo.png') }}" alt="main-logo">
        <br>
        <br>
        <h2 class="text-center">Jay College of Health Sciences Inc</h2>
        <h4 class="text-center">5275 Babcock Street NE, Suite #3, Palm Bay, FL 32905</h4>
        <h6 class="text-center">Phone: (321) 725-1515</h6>
        <h6 class="text-center">Fax: (321) 733-0779</h6>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-md-4 text-center">
        <img src="{{ asset('/public/StudentImage' . '/' . $student->image) }}" alt="{{ $student->firstName }}">
      </div>
      <div class="col-md-offset-2 col-md-6">
        <table class="table table-striped">
          <tbody>
            <tr>
              <td><b>First Name:</b></td>
              <td>{{ $student->firstName }}</td>
            </tr>
            <tr>
              <td><b>Middle Name:</b></td>
              <td>{{ $student->middleName }}</td>
            </tr>
            <tr>
              <td><b>Last Name:</b></td>
              <td>{{ $student->lastName }}</td>
            </tr>
            <tr>
              <td><b>Student ID:</b></td>
              <td>{{ $student->studentID }}</td>
            </tr>
            <tr>
              <td><b>Student Program:</b></td>
              <td>{{ $student->program_id }}</td>
            </tr>
            <tr>
              <td><b>Student Session:</b></td>
              <td>{{ $student->studentSession }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <br>
    <div class="row">
      {{-- details --}}
      <div class="col-md-4">
        <table class="table table-borderless">
          <tbody>
            <tr>
              <td><b>Gender</b></td>
              <td>{{ $student->gender }}</td>
            </tr>
            <tr>
              <td><b>Date of Birth</b></td>
              <td>{{ $student->dob }}</td>
            </tr>
            <tr>
              <td><b>Email</b></td>
              <td>{{ $student->email }}</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="col-md-4">
        <table class="table table-borderless">
          <tbody>
            <tr>
              <td><b>Phone</b></td>
              <td>{{ $student->phone }}</td>
            </tr>
            <tr>
              <td><b>Address</b></td>
              <td>{{ $student->address }}</td>
            </tr>
            <tr>
              <td><b>State</b></td>
              <td>{{ $student->state }}</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="col-md-4">
        <table class="table table-borderless">
          <tbody>
            <tr>
              <td><b>Zip</b></td>
              <td>{{ $student->zip }}</td>
            </tr>
            <tr>
              <td><b>Total Tuition</b></td>
              <td>{{ $student->totalTution }}</td>
            </tr>
            <tr>
              <td><b>Total Paid</b></td>
              <td>{{ $student->totalPaid }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <script>
    $(document).ready(function() {
      window.print();
    });
  </script>
</body>

</html>

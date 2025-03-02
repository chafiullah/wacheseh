<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Withdrawn Refurn Form of {{ $student->studentID }}</title>
  <link rel="stylesheet" href="{{ asset('assets/transcript/bootstrap4.min.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Carattere&family=Lato" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      font-family: 'Lato', sans-serif;
    }

    .title-head {
      font-size: 20px;
      font-weight: 700;
    }

    .title-data,
    .main-data {
      font-size: 20px;
      text-align: left;
    }

    .marks-data {
      padding: 5px !important;
      font-size: 14px !important;
    }

    .course-title {
      width: 20%;
    }

    .course-name {
      width: 50%;
    }

    .letter-grade {
      width: 5%;
    }

    .course-credit {
      width: 5%;
    }

  </style>
</head>

<body>
  <div class="container-fluid">
    <div class="row mt-2">
      <div class="col-md-12 text-center">
        <img src="{{ asset('assets/images/main_logo.png') }}" alt="">
        <br>
        <span style="font-family:'Carattere', cursive;font-size: 20px;font-weight: bold;">Jay College of Health
          Sciences Inc</span>
        <br>
        <span style="font-size: 16px;font-weight: bold;">5275 Babcock Street NE, Suite #3, Palm Bay, FL 32905
        </span>
        <br>
        <span style="font-size: 16px;font-weight: bold;">Phone: (321) 725-1515</span>
        <br>
        <span style="font-size: 16px;font-weight: bold;">Fax: (321) 733-0779</span>
      </div>
    </div>
    <!-- basic info -->
    <div class="row">
      <div class="col-md-12">
        <h4 class="mb-2"><u><b>Student's Data:</b></u></h4>
      </div>
      <div class="col-md-7">
        <table class="table table-borderless">
          <tr>
            <td class="title-head">Name:</td>
            <td class="title-data">
              {{ $student->firstName }}&nbsp;{{ $student->middleName }}&nbsp;{{ $student->lastName }}
            </td>
          </tr>
          <tr>
            <td class="title-head">Student&nbsp;ID#:</td>
            <td class="title-data">{{ $student->studentID }}</td>
          </tr>
          <tr>
            <td class="title-head">SSN:</td>
            <td class="title-data">*** - ** - {{ substr($student->ssn, -4) }}</td>
          </tr>
          <tr>
            <td class="title-head">DOB:</td>
            <td class="title-data">{{ \Carbon\Carbon::parse($student->dob)->format('m/d/Y') }}</td>
          </tr>
          <tr>
            <td class="title-head">Email&nbsp;Address:</td>
            <td class="title-data">{{ $student->email }}</td>
          </tr>
          {{-- <tr>
                        <td class="title-head">Current Status:</td>
                        <td class="title-data">{{ $student->department->short_name }}</td>
                    </tr> --}}
          {{-- <tr>
            <td class="title-head">Awarded Degree:</td>
            <td class="title-data">{{ $student->degreeProgram }}</td>
          </tr> --}}
        </table>
      </div>
      <div class="col-md-5">
        <table class="table table-borderless">
          <tr>
            <td class="title-head">Phone&nbsp;Number:</td>
            <td class="title-data">{{ $student->phone }}</td>
          </tr>
          <tr>
            <td class="title-head">Address:</td>
            <td class="title-data">{{ $student->address }}</td>
          </tr>

          <tr>
            <td class="title-head">City:</td>
            <td class="title-data">{{ $student->city }}</td>
          </tr>
          <tr>
            <td class="title-head">State:</td>
            <td class="title-data">{{ $student->state }}</td>
          </tr>
          <tr>
            <td class="title-head">Zip:</td>
            <td class="title-data">{{ $student->zip }}</td>
          </tr>
          {{-- <tr>
            <td class="title-head">Academic&nbsp;Year&nbsp;Attended:</td>
            <td class="title-data">
              {{ \Carbon\Carbon::parse($student->studentSession)->format('d M Y') }} -
              {{ \Carbon\Carbon::parse($programEnded)->format('d M Y') }}</td>
          </tr> --}}
        </table>
      </div>
    </div>

    <!-- Academic Records -->
    <div class="row">
      <div class="col-md-12">
        <h4 class="text-center"><u><b>Refund Statement</b></u></h4>
      </div>
    </div>
    {{-- First Page Starts Here --}}
    <!-- First Table Courses, these courses are transferred courses-->
    <div class="row">
      <div class="col-md-12">
        <table class="table table-borderless">
          <tbody>
            <tr>
              <td class="main-data course-name">TOTAL CREDIT COMPLETED:</td>
              <td class="main-data">{{ $credits_completed }}</td>
            </tr>
            <tr>
              <td class="main-data">AMOUNT PAID:</td>
              <td class="main-data">${{ $total_paid['totalPaid'] }}</td>
            </tr>
            <tr>
              <td class="main-data">TUITION BALANCE:</td>
              <td class="main-data">${{ $total_paid['totalBalance'] }}</td>
            </tr>
            <br>
            <br>
            <tr>
              <td class="main-data">AMOUNT PER CREDIT:</td>
              <td class="main-data">$292</td>
            </tr>
            <tr>
              <td class="main-data">TOTAL CREDIT PER COURSE:</td>
              <td class="main-data"><b><u>5 FOR LAB COURSES AND 3 FOR THEORY COURSES</u></b></td>
            </tr>
            <tr>
              <td class="main-data">TOTAL AMOUNT PER COURSE:</td>
              <td class="main-data"><b><u>$292 x 5 = $1460</u></b></td>
            </tr>
            <tr>
              <td class="main-data">TOTAL AMOUNT:</td>
              <td class="main-data">${{ $credits_completed * 292 }}</td>
            </tr>
          </tbody>
        </table>
        <br>
        <br>
        <table class="table table-borderless">
          <tbody>
            <tr>
              <td class="main-data"><b><u>REFUND CALULATED AS:</u></b></td>
            </tr>
            <tr>
              <td class="title-head">OPTION 1: TOTAL CREDIT COMPLETED MULTIPLIED BY AMOUNT PER CREDIT($292). THE RESULT OF (OPTION 1) SUBTRACTED FROM TOTAL AMOUNT PAID IS THE AMOUNT TO BE
                REFUNDED.</td>
            </tr>
          </tbody>
        </table>
        <br>
        <br>
        <table class="table table-borderless">
          <tbody>
            <tr>
              @if ($refund_amount > 0)
                <td class="title-head">AMOUNT BE REFUNDED IF OVERPAID:</td>
                <td class="main-data">${{ $refund_amount }}</td>
              @else
                <td class="title-head">AMOUNT OWE IF BELOW PAID:</td>
                <td class="main-data">${{ -1 * $refund_amount }}</td>
              @endif
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    {{-- First Page Ends Here --}}
  </div>
  <script>
    window.onload = function() {
      window.print()
    };
  </script>
</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>{{ $details->studentID }} - Attendance Request Form</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    .student-data {
      color: black;
      font-size: 12px;
      font-weight: bold;
    }

    #student_name {
      margin: 42.2% 0 0 20%;
      position: absolute;
    }

    #student_id {
      margin: 45.5% 0 0 18%;
      position: absolute;
    }

    #student_enrolled_month {
      margin: 49% 0 0 22.5%;
      position: absolute;
    }

    #student_enrolled_date {
      margin: 49% 0 0 28%;
      position: absolute;
    }

    #student_enrolled_year {
      margin: 49% 0 0 33%;
      position: absolute;
    }

    #student_degree {
      margin: 52.7% 0 0 24%;
      position: absolute;
    }

    #signature {
      position: absolute;
      margin: 69.5% 0 0 63%;
    }

  </style>
</head>

<body>
  {{-- name --}}
  <span class="student-data" id="student_name">{{ $details->firstName . ' ' . $details->middleName . ' ' . $details->lastName }}</span>
  {{-- id --}}
  <span class="student-data" id="student_id">{{ $details->studentID }}</span>
  {{-- dates --}}
  <span class="student-data" id="student_enrolled_month">{{ Carbon\Carbon::parse($details->studentSession)->format('m') }}</span>
  <span class="student-data" id="student_enrolled_date">{{ Carbon\Carbon::parse($details->studentSession)->format('d') }}</span>
  <span class="student-data" id="student_enrolled_year">{{ Carbon\Carbon::parse($details->studentSession)->format('Y') }}</span>
  {{-- program --}}
  <span class="student-data" id="student_degree">{{ $details->degreeProgram }}</span>
  {{-- signature --}}
  <img src="{{ public_path('signatures/chimizie-sig.png') }}" width="120" id="signature">
  {{-- content --}}
  <img src="{{ public_path('attendance/attendance-request.png') }}" width="700" alt="">
  </div>
</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>{{ $studentInfo->studentID }} - Exhibit Enrollment Form</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    .page-break-after {
      page-break-after: always
    }

    @media print {
      span {
        font-family: 'Roboto', sans-serif;
        font-size: 28px;
        font-weight: bolder;
        position: absolute;
        letter-spacing: 2px;
      }

      #names {
        margin: 29% 0px 0px 30%;
      }

      #address {
        margin: 35% 0px 0px 30%;
      }

      #phone1 {
        margin: 43.2% 0px 0px 67.5%;
      }

      #phone2 {
        margin: 43.2% 0px 0px 75%;
      }

      #program1 {
        margin: 83% 0px 0px 28%;
      }

      #program2 {
        margin: 93% 0px 0px 28%;
      }

      #creditHours {
        margin: 97% 0px 0px 25%;
      }

      #program_started {
        margin: 102.5% 0px 0px 30%;
      }

      #program_ends {
        margin: 102.5% 0px 0px 50%;
      }

      #totalTuition {
        margin: 28% 0px 0px 44%;
      }

      #registration {
        margin: 31% 0px 0px 44%;
      }

      #programCost {
        margin: 45% 0px 0px 44%;
      }

      #hasPaidConfirm {
        margin: 95.7% 0px 0px 6%;
      }

      #amountOfEach {
        margin: 57.3% 0px 0px 29%;
      }

      #checkWhenDue {
        margin: 59% 0px 0px 59.2%;
      }


    }

  </style>
</head>

<body>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12 page-break-after text-center">
        <span id="names">{{ $studentInfo->lastName }}&nbsp;&nbsp;{{ $studentInfo->firstName }}&nbsp;&nbsp;{{ $studentInfo->middleName }}</span>

        <span id="address">{{ $studentInfo->address }}&nbsp;&nbsp;{{ $studentInfo->city }}&nbsp;&nbsp;{{ $studentInfo->state }},&nbsp;{{ $studentInfo->zip }}</span>

        <span id="program1">{{ $studentInfo->degreeProgram }}</span>
        <span id="program2">{{ $studentInfo->degreeProgram }}</span>
        <span id="creditHours">
          @if ($studentInfo->degreeProgram == 'Bachelors Degree of Science in Nursing(BSN)')
            133
          @else
            72
          @endif
        </span>
        <span id="program_started">{{ Carbon\Carbon::parse($studentInfo->studentSession)->format('m/d/Y') }}</span>
        <span id="program_ends">{{ Carbon\Carbon::parse($studentInfo->studentSession)->addYear(2)->format('m/d/Y') }}</span>
        <span id="phone1">{{ substr($studentInfo->phone, 0, 3) }}</span>
        <span id="phone2">{{ substr($studentInfo->phone, 4) }}</span>
        <img src="{{ Storage::url('app/public/exhibitForm/exhibit_1.jpg') }}">
      </div>
      <div class="col-md-12 page-break-after text-center">
        <span id="totalTuition">{{ $studentInfo->totalTution }}</span>
        <span id="registration">150</span>
        <span id="programCost">{{ $studentInfo->totalTution + 150 }}</span>
        <span id="hasPaidConfirm"><i class="fas fa-check    "></i></span>
        <img src="{{ Storage::url('app/public/exhibitForm/exhibit_2.jpg') }}">
      </div>
      <div class="col-md-12 page-break-after text-center">
        <span id="amountOfEach">1000.00</span>
        <span id="checkWhenDue"><i class="fas fa-check    " style="font-size: 48px"></i></span>
        <img src="{{ Storage::url('app/public/exhibitForm/exhibit_3.jpg') }}" style="margin-top: -20%">
      </div>
      <div class="col-md-12 page-break-after text-center">
        <img src="{{ Storage::url('app/public/exhibitForm/exhibit_4.jpg') }}" style="margin-top: -20%">
      </div>
      <div class="col-md-12 page-break-after text-center">
        <img src="{{ Storage::url('app/public/exhibitForm/exhibit_5.jpg') }}" style="margin-top: -60%">
      </div>
    </div>
  </div>

  {{-- Scripts --}}
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    window.onload = function() {
      window.print()
    };
  </script>
</body>

</html>

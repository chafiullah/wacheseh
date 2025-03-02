<!doctype html>
<html lang="en">
<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>


    <style>
        body{
          background-color: #eee;
        }
    </style>
</head>
<body>
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-4">
        <div class="card">
            <div class="card-header">
              Featured
            </div>
            <div class="card-body">
     <form action="{{route('event.store')}}" method="post">
      {{@csrf_field()}}
      <div class="form-group">
      <label for="title">Event Title</label>
      <input type="text" id="title" class="form-control is-valid" name="title" placeholder="Enter the title"  >
      </div>
      <div class="form-group">
      <label for="color">Color</label>
      <input type="color" id="color" class="form-control" name="color" placeholder="Enter the color"   >
      </div>
      <div class="form-group">
      <label for="date">Enter start date</label>
      <input type="datetime-local" id="date" class="form-control" name="start_date" placeholder="Enter start date"  >
      </div>
      <div class="form-group">
      <label for="date">Enter End  date</label>
      <input type="datetime-local" id="date" class="form-control" name="end_date" placeholder="Enter End date"  >
      </div>
  <button class="btn btn-info" type="submit">Add Event</button>
</form>

            </div>
          </div>
          <div class="card-footer">
              <a  class="btn btn-danger" href="{{ route('admin.home') }}"> GO BACK</a>
          </div>

      </div>

      <div class="col-md-8">
        <div class="alert alert-success" role="alert">
  <h1 class="text-center"> Academic Calendar with Event </h1>
        </div>
        <div>
          {!! $calendar->calendar() !!}
       {!! $calendar->script() !!}
        </div>
      </div>
    </div>
  </div>
</body>
</html>
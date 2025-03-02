<!DOCTYPE html>
<html lang="en">
<head>
	<title>Student Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/login/') }}/vendor/bootstrap/css/bootstrap.min.css">

</head>
<body>
	
	<div class="container">
		<div class="row">
			<div class="col-12">
				<table class="table">
					<thead>
						<tr>
							<th>User ID</th>
							<th>Event</th>
							<th>Auditable Type</th>
							<th>Old Values</th>
							<th>New Values</th>
							<th>URL</th>
							<th>IP address</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($audits as $a)
							<tr>
								@php
									$na = App\User::where('id',$a->user_id)->first();
								@endphp
								<td>{{ $na->name }}</td>
								<td>{{ $a->event }}</td>
								<td>{{ $a->auditable_type }}</td>
								<td>{{ $a->old_values }}</td>
								<td>{{ $a->new_values }}</td>
								<td>{{ $a->url }}</td>
								<td>{{ $a->ip_address }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			{{$audits->links()}}
		</div>
	</div>
	
<!--===============================================================================================-->
	<script src="{{ asset('assets/login/') }}/vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="{{ asset('assets/login/') }}/vendor/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
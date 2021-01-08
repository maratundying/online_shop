<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Password recovery</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
	<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
	@if(Session::has('emailerror'))
		<div class="alert alert-danger" align='center'>
			{{Session::get('emailerror')}}
		</div>
	@endif

	@if(count($errors)>0)
		<div class="alert alert-danger" align="center">
			<ul>
				@foreach($errors->all() as $error)
					<li>{{$error}}</li>
				@endforeach
			</ul>
		</div>
	@endif
	<div class="container box" style="width:500px !important">
		<form id="form" action="{{URL::to('/recoverPassword')}}" method="POST">
			{{csrf_field()}}
			<div class="form-group">
				<label for="email">eMail</label>
				<input type="text" name="email" id="email" class="form-control" placeholder="Enter your email" value="{{old('login')}}">
			</div>
		</form>
		<div id="buttons">
			<button id='recoveryButton' type='button' class="btn btn-primary">Recover</button>
			<a href="{{URL::to('/login')}}">Sign in</a>
		</div>
	</div>
</body>
<script src="{{URL::asset('js/recovery_script.js')}}"></script>
</html>
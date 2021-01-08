<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
	@if(Session::has('blocked'))
	<div class="alert alert-danger" style="display:flex;justify-content:center;width: 100%">
		{{Session::get('blocked')}}
	</div>
	@endif

	@if(Session::has('activation'))
	<div class="alert alert-danger" style="display:flex;justify-content:center;width: 100%">
		{{Session::get('activation')}}
	</div>
	@endif

	@if(Session::has('changed'))
		<div class="alert alert-danger" style="display:flex;justify-content:center;width: 100%">
		{{Session::get('changed')}}
	</div>
	@endif

	@if(Session::has('registration_completed'))
	<div class="alert alert-danger" style="display:flex;justify-content:center;width: 100%">
		{{Session::get('registration_completed')}}
	</div>
	@endif
	@if(count($errors)>0)
		<div class="alert alert-danger" >
			<ul align="center">
				@foreach($errors->all() as $error)
					<li>{{$error}}</li>
				@endforeach
			</ul>
		</div>
	@endif

	@if(Session::has('error'))
		<div class='alert alert-danger' align='center'><li>{{Session::get('error')}}</li></div>
	@endif
	<div class="container box" style="width:500px !important">
		<form action="{{URL::to('login_form')}}" method='post'>
			{{csrf_field()}}
			<div class="form-group">
				<label for="loginLogin">Login</label>
				<input type="text" name="login" id="loginLogin" class="form-control" placeholder="Login" value="{{old('login')}}">
			</div>
			<div class="form-group">
				<label for="loginPassword">Password</label>
				<input type="password" id="loginPassword" name="password" class="form-control" placeholder="Password">
			</div>
			<a href="{{URL::to('forgetPassword')}}">Forget password?</a><br>
			<a href="{{URL::to('toSignupPage')}}">Haven't registered yet? Register now !</a><br>
			<button class="btn btn-primary">Log in</button>
		</form>
	</div>
</body>
<script src="{{URL::asset('js/login_script.js')}}"></script>
</html>
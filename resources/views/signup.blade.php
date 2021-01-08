<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="{{URL::asset('css/styles.css')}}">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container box" align="center">
	<h1 align="center">Signup</h1>
	@if(count($errors)>0)
		<div class="alert alert-danger">
			<ul>
				@foreach($errors->all() as $error)
					<li>{{$error}}</li>
				@endforeach
			</ul>
		</div>
	@endif
		<form action="{{URL::to('signup_form')}}" method="post" align='start'>
			{{csrf_field()}}
				<label for="">Name</label>
				<input type="text" name="name" class="form-control" value="{{old('name')}}">

				<label for="">Surname</label>
				<input type="text" name="surname" class="form-control" value="{{old('surname')}}">

				<label for="">Age</label>
				<input type="text" name="age" class="form-control" value="{{old('age')}}">

				<label for="">Email</label>
				<input type="text" name="email" class="form-control"  value="{{old('email')}}">

				<label for="">Phone Number</label>
				<input type="text" name="phone" class="form-control"  value="{{old('phone')}}">

				<label for="">Password</label>
				<input type="password" name="password" class="form-control" >

				<label for="">Confirm Password</label>
				<input type="password" name="confirm" class="form-control" >

				<a href="{{URL::to('/login')}}" align='center'>I have an account</a>
			<button class="btn btn-primary">Registrartion</button>
		</form>
	</div>
</body>
<script src="{{URL::asset('js/script.js')}}"></script>
</html>
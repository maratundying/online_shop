<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Email</title>
</head>
<body>
	<h1>Hello {{$name}} </h1>
	<a href="{{URL::to('/checkuser'.'/'.$hash.'/'.$email)}}">Click here to complete registration</a>
</body>
</html>
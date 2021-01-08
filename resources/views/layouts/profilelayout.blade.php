<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	@yield('title')
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	@yield('css')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="{{URL::asset('css/styles.css')}}">
	<meta name="csrf-token" content="{{ csrf_token() }}" />
</head>
<body>
		<div id="header">
			<a href="{{URL::to('toMainPage')}}">SITE.COM</a>
			<div id="search">
				<label for="search-input"><i class="fa fa-search" aria-hidden="true"></i></label>
				<input type="text" id='search-input' placeholder="Search">
			</div>	
			<div id="user_data">
				<img src="/{{$person->image}}" alt="Image">
				<span> {{$person->name}} </span>
				<div id="header_data">
					<a href="{{URL::to('/myproducts')}}"><i class="fa fa-list" aria-hidden="true"></i>My products</a>
					<a href="{{URL::to('/messages')}}"><i class="fa fa-comment" aria-hidden="true"></i>Messages</a>
					<a href="{{URL::to('/favorite')}}"><i class="fa fa-star" aria-hidden="true"></i>Favorite</a>
					<a href="{{URL::to('/orders')}}"><i class="fa fa-bell" aria-hidden="true"></i>Orders</a>
					@if	(Session::has('adminid'))
					<a href="{{URL::to('/admin')}}"><i class="fa fa-user-circle" aria-hidden="true">Administration</i></a>
					@endif
					<a id="edit" data-toggle="modal" data-target="#myModal"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
					<a href="{{URL::to('/logout')}}"><i class="fa fa-sign-out" aria-hidden="true"></i>Log Out</a>
				</div>
			</div>
			<div id="addProductDiv">
				<a href="{{URL::to('/toAddProduct')}}" id="addProduct">Add product</a>
				<a href="{{URL::to('/basket')}}" id="toBasket"><i class="fa fa-shopping-basket basket" aria-hidden="true"></i></a>
			</div>
		</div>

		<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Change data</h4>
      </div>
      <div class="modal-body">
		<form id="form">
			{{csrf_field()}}
			@if(count($errors)>0)
			<div class="alert alert-danger">
				<ul>
					@foreach($errors->all() as $error)
						<li>{{$error}}</li>
					@endforeach
				</ul>
			</div>
			@endif
		      	<label for="">Name</label>
		      	<input type="text" id="changeName" class="form-control" value="{{$person->name}}">

		      	<label for="">Surname</label>
		      	<input type="text" id="changeSurname" class="form-control" value="{{$person->surname}}">
				
				<label for="">Age</label>
		      	<input type="text" id="changeAge" class="form-control" value="{{$person->age}}">      	

				<label for="">Email</label>
		      	<input type="text" id="changeEmail" class="form-control" value="{{$person->email}}">
	    	</div>
	      <div class="modal-footer">
	      	<button type="button" class="btn btn-success" id="changeData">Change</button>
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
  		</form>
    </div>

  </div>
</div>
	@yield('categories')

	@yield('content')

</body>
<script src="{{URL::asset('js/script.js')}}"></script>
@yield('scripts')
</html>
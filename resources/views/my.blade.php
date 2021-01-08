@extends ('layouts/profilelayout')

@section('title')
	<title>My products</title>
@endsection

@section('css')
	<link rel="stylesheet" href="{{URL::asset('css/myproductsstyles.css')}}">
@endsection

@section('content')
	<div id="content">
		@if(count($products)>0)
		@foreach($products as $product)
			<div class="thisProduct" data-id='{{$product->id}}'>
				@if(count($product->image_child)>0)
					<img src="{{URL::asset($product->image_child[0]['photo'])}}" alt="">
				@else
					<img src="https://pngimage.net/wp-content/uploads/2018/06/none-png-8.png" alt="image">
				@endif
				<div>
					<a href="{{URL::to('item'.'/'.$product->id)}}"><span>{{$product->name}}</span></a>
					<strong>{{$product->price}}$ </strong>
					<p>{{$product->description}}</p>
					@if($product->activated==0)
						<strong>Your product has been refused:</strong>
						Reason - {{$product->getMessage->feedback}}
					@endif
				</div>
				@if($product->activated==0)
					<div class="red" title="Not activated"></div>
				@endif

				@if($product->activated==1)
					<div class="yellow" title="Activating"></div>
				@endif

				@if($product->activated==2)
					<div class="green" title="Activated"></div>
				@endif
			</div> 
		@endforeach
			@else
				<div class="alert alert-danger" style="display:flex;justify-content:center;width: 100%">
					You don't have any product
				</div>
		@endif
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
		<form action="{{URL::to('changeData')}}" method="POST">
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
		      	<input type="text" name="changeName" class="form-control" value="{{$person->name}}">

		      	<label for="">Surname</label>
		      	<input type="text" name="changeSurname" class="form-control" value="{{$person->surname}}">
				
				<label for="">Age</label>
		      	<input type="text" name="changeAge" class="form-control" value="{{$person->age}}">      	

				<label for="">Email</label>
		      	<input type="text" name="changeEmail" class="form-control" value="{{$person->email}}">
	    	</div>
	      <div class="modal-footer">
	      	<button class="btn btn-success">Change</button>
	        <button class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
  		</form>
    </div>
  </div>
</div>	

@endsection
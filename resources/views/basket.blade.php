@extends('layouts/profilelayout')

@section('title')
<title>Basket</title>
@endsection

@section('css')
<link rel="stylesheet" href="{{URL::asset('css/basket_styles.css')}}">
@endsection

@if (Session::has('success'))
    <div class="alert alert-success text-center">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        <p>{{ Session::get('success') }}</p>
    </div>
@endif

@section('content')
	<div id="content">
	<div id="contentBody">
		@if(count($basket)>0)
			@foreach($basket as $product)
				<div class="thisProduct" data-id='{{$product->id}}' data-count='{{$product->parent_product->count}}' data-productcount='{{$product->count}}' data-productid='{{$product->parent_product->id}}'>
					@if(count($product->product_images)>0)
						<img src="{{$product->product_images[0]['photo']}}" alt="">

						@else
						<img src="https://pngimage.net/wp-content/uploads/2018/06/none-png-8.png" alt="image">
						
					@endif

					<a href="{{URL::to('item'.'/'.$product->parent_product->id)}}"><strong>{{$product->parent_product->name}}</strong></a>
					<h4>{{$product->parent_product->price}}$</h4>
					<p>{{$product->parent_product->description}}</p>
					<div id="buttons">
						<i class="fa fa-minus minus" aria-hidden="true"></i>
						<input type="number" id='basketCount' min='1' value='{{$product->count}}'>
						<i class="fa fa-plus plus" aria-hidden="true"></i><br>
						<a  class="buyy"><i class="fa fa-check buy" aria-hidden="true"></i></a>
					</div>
					<!-- {{URL::to('stripe')}} -->
					<div class="price">
						<b>{{$product->count*$product->parent_product->price}}</b>
						<strong>$</strong>
					</div>
					<button type="button" id="removeFromCard">Remove from card</button>
				</div>
			@endforeach
			@endif
			@if(count($basket)<1)
				<div class="alert container alert-success" align='center'>The basket is empty</div>
			@endif

		</div>
	</div>

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

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

@section('scripts')
<script src="{{URL::asset('js/basket_script.js')}}"></script>
@endsection

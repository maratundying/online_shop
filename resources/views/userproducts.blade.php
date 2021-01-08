@extends('layouts/profilelayout')

@section('title')
	<title>{{$person->name}} {{$person->surname}}</title>
@endsection

@section('css')
<link rel="stylesheet" href="{{URL::asset('css/profilestyles.css')}}">
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
					<a href="{{URL::to('item'.'/'.$product->id)}}">{{$product->name}}</a>
					<strong>{{$product->price}}$ </strong>
					<p>{{$product->description}}</p>
				</div>
			</div>
	@endforeach
		@else

		<div class="alert alert-danger" style="display:flex;justify-content:center;width: 100%">
			Nothing to show
		</div>
	@endif
	</div>
@endsection
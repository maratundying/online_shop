@extends('layouts/profilelayout')

@section('title')
<title>Account</title>
@endsection

@section('css')
<link rel="stylesheet" href="{{URL::asset('css/account_styles.css')}}">
@endsection

@section('categories')
	<ul id="categories">
		@foreach($categories as $category)
			<li data-id='{{$category->id}}'>{{$category->category}}</li>
		@endforeach		
	</ul>
@endsection

@if(Session::has('warning'))
<div class="alert alert-danger">
	<p align="center">{{Session::get('warning')}}</p>
</div>
@endif



@if(Session::has('notactivated'))
<div class="alert alert-danger">
	<p align="center">{{Session::get('notactivated')}}</p>
</div>
@endif

@section('content')
	<div id="content">
		@foreach($allProduct->all() as $product)
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
	</div>



@endsection

@section('scripts')
<script src="{{URL::asset('js/account_script.js')}}"></script>
@endsection

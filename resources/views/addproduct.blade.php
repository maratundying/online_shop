@extends('layouts/profilelayout')

@section('title')
<title>Adding product</title>
@endsection

@section('css')
<link rel="stylesheet" href="{{URL::asset('css/styles.css')}}">

<style>
	form{
		text-align: center;
	}

	.container{
		margin-top: 10px;
		width: 50% !important;
	}

	form input[type=file]{
		margin:auto;
		margin-bottom: 10px
	}
</style>
@endsection

@section('content')
	@if(count($errors)>0)
		<div class="alert alert-danger container center" >
			<ul>
				@foreach($errors->all() as $error)
					<li>{{$error}}</li>
				@endforeach
			</ul>
		</div>
	@endif
	<div class="container">
	<form action="{{URL::to('addProduct')}}" method='POST' enctype="multipart/form-data">
		{{csrf_field()}}
		<div >
		<input type="text" value="{{old('name')}}" name="name" class="form-control" placeholder="Name">
		<input type="text" value="{{old('price')}}" name="price" class="form-control" placeholder="Price">
		<input type="text" value="{{old('count')}}" name="count" class="form-control" placeholder="Count">
		<select name="category" id="">
			<option value="" selected="" disabled="">Select category</option>
			@foreach($categories as $category)
				<option value="{{$category->id}}">{{$category->category}}</option>
			@endforeach
		</select>
		</div>
		<textarea name="description" class="form-control" placeholder="Description" style="resize: none"></textarea><br>
		<input type="file" name="images[]" multiple>
		<button class="btn btn-success">Add</button>
		</div>
	</form>
	</div>

@endsection

@section('scripts')
<script src="{{URL::asset('js/addproduct_js.js')}}"></script>
@endsection
@extends ('layouts/profilelayout')

@section('title')
<title>Favorites</title>
@endsection

@section('css')
<link rel="stylesheet" href="{{URL::asset('css/favorite.css')}}">
@endsection

@section('content')
	<div id="content">
		@if(count($favorites)>0)
		@foreach($favorites as $favorite)
			<div class="thisProduct" data-id='{{$favorite->id}}'>
				@if(count($favorite->favorite_images)!=0)
					<img src="{{URL::asset($favorite->favorite_images[0]['photo'])}}" alt="">
				@else
					<img src="https://pngimage.net/wp-content/uploads/2018/06/none-png-8.png" alt="image">
				@endif
				<div>
					<a href="{{URL::to('item'.'/'.$favorite->parent_product['id'])}}"><span>{{$favorite->parent_product['name']}}</span></a>
					<strong>{{$favorite->parent_product->price}}$ </strong>
					<p>{{$favorite->parent_product->description}}</p>
				</div>
				<i class="fa fa-times removeFromFavorites" title='Remove favorite' aria-hidden="true"></i>
			</div> 
		@endforeach
			@else
			
		<div class="alert alert-danger" style="display:flex;justify-content:center;width: 100%">
			Nothing to show
		</div>
		@endif
	</div>


@endsection

@section('scripts')
<script src="{{URL::asset('js/favorite_js.js')}}"></script>
@endsection

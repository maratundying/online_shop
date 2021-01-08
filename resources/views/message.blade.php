@extends('layouts/profilelayout')

@section('title')
	<title>Message</title>
@endsection

@section('css')
	<link rel="stylesheet" href="{{URL::to('css/message_styles.css')}}">
@endsection

@section('content')

	<div class="container" id="container">
	@if($message->sender_id==Session::get('userId'))
		<div id="div1">
			<div id="ddiv1">
				<img src="/{{$message->outcoming_user->image}}" alt="">
				<span>{{$message->outcoming_user->name}} {{$message->outcoming_user->surname}}</span>
			</div>
			<div id="ddiv2">
				<span>{{$message->created_at->format('d/m/Y H:i')}}</span>
				<span><i class="fa fa-times" aria-hidden="true"></i></span>
			</div>
		</div>

		<div id="div2">
			<img src="/{{$message->parent_product_images[0]['photo']}}" alt="">
			<p>{{$message->parent_product->name}}</p>
		</div>

		<div id="div4">
			{{$message->message}}
		</div>

		<div id="div3">
			<input type="text" id="messageInput" placeholder="New message">
			<button type="button" id="sendMessage"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
		</div>
	@endif
	
	@if($message->user_id==Session::get('userId'))
		<div id="div1">
			<img src="/{{$message->incoming_user->image}}" alt="">
			<span>{{$message->incoming_user->name}} {{$message->incoming_user->surname}}</span>
			<span><i class="fa fa-times" aria-hidden="true"></i></span>
			<span>{{$message->created_at->format('d/m/Y H:i')}}</span>
		</div>

		<div id="div2">
			@if(count($message->parent_product_images)>0)
				<img src="/{{$message->parent_product_images[0]['photo']}}" alt="">
				@else 
				<img style="border:1px solid gray" src="https://pngimage.net/wp-content/uploads/2018/06/none-png-8.png" alt="image">
			@endif
			<p>{{$message->parent_product->name}}</p>

		</div>
		<div id="div4">
			{{$message->message}}
		</div>
		<div id="div3">
			<input type="text" id="responceInput" placeholder="Respond">
			<button type="button" id="respond"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
		</div>
	@endif
	</div>
@endsection

@section('scripts')
<script src="{{URL::asset('js/messages_script.js')}}"></script>
@endsection
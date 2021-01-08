@extends('layouts/profilelayout')

@section('title')
<title>My messages</title>
@endsection

@section('css')
<link rel="stylesheet" href="{{URL::asset('css/messages_styles.css')}}">
@endsection

@section('content')
	<div id="content" class="container">
		@if(count($messages)>0)
		<div align="center">
			<a href="{{URL::to('/incoming')}}">Incoming</a>
			<a href="{{URL::to('/outcoming')}}">Outcoming</a>
		</div>
		
		@foreach($messages as $message)
			@if($message->user_id==Session::get('userId'))
				<div class="incomingMessage">
					<div id="div1">
						<i class="fa fa-arrow-down" aria-hidden="true"></i>
						<img src="{{$message->incoming_user->image}}" alt="">
						<span>{{$message->incoming_user->name}} {{$message->incoming_user->surname}}</span>
					</div>
					<div id="div2" style="cursor:pointer" onclick="window.open('{{URL::to('message/'.$message->id)}}','_self');">
						<p>{{$message->parent_product->name}}</p>
						<p>{{$message->message}}</p>
					</div>

					<div id="div3">
						<span>{{$message->created_at->format('d/m/Y H:i')}}</span>
						<i class="fa fa-times" aria-hidden="true"></i>
					</div>
				</div>
			@endif

			@if($message->sender_id==Session::get('userId'))
				<div class="outcomingMessage">
					<div id="div1">
						<i class="fa fa-arrow-up" aria-hidden="true"></i>
						<img src="{{$message->outcoming_user->image}}" alt="">
						<span>{{$message->outcoming_user->name}} {{$message->outcoming_user->surname}}</span>
					</div>
					<div id="div2" style="cursor:pointer" onclick="window.open('{{URL::to('message/'.$message->id)}}','_self');">
						<p>{{$message->parent_product->name}}</p>
						<p>{{$message->message}}</p>
					</div>

					<div id="div3">
						<span>{{$message->created_at->format('d/m/Y H:i')}}</span>
						<i class="fa fa-times" aria-hidden="true"></i>
					</div>

				</div>
			@endif			
		@endforeach
		@else

		<div class="alert alert-danger" style="display:flex;justify-content:center;width: 100%">
			Nothing to show
		</div>
		@endif
	</div>
@endsection

@section('scripts')

@endsection
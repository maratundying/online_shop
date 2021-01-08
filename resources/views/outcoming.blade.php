@extends('layouts/profilelayout')

@section('title')
	<title>{{$person->name}} {{$person->surname}} - Outbox</title>
@endsection

@section('css')
	<link rel="stylesheet" href="{{URL::asset('css/outcoming_messages_styles.css')}}">
@endsection

@section('content')
<div id="content" class="container">
		<div align="center">
			<a href="{{URL::to('/incoming')}}">Incoming</a>
			<a href="{{URL::to('/outcoming')}}">Outcoming</a>
		</div>
	<div id="content">
		@if(count($outcoming)>0)
		@foreach($outcoming as $message)
		<div class="message" data-id='{{$message->id}}'>
			<div id="div1">
				<img src="{{$message->outcoming_user->image}}" alt="">
				{{$message->outcoming_user->name}} {{$message->outcoming_user->surname}}
			</div>
			
			<div id="div2" style="cursor:pointer" onclick="window.open('{{URL::to('message/'.$message->id)}}','_self');">
				<p>{{$message->parent_product->name}}</p>
				<div>{{$message->message}}</div>
			</div>

			<div id="div3">
				{{$message->created_at->format('d/m/Y H:i:s')}}
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

@section('scripts')

@endsection
@extends('layouts/profilelayout')

@section('title')
<title> {{$person->name}} {{$person->surname}} </title>
@endsection

@section('css')
<link rel="stylesheet" href="{{URL::asset('css/admin_styles.css')}}">
@endsection

@section('content')
	<div id="app">
		<admin-menu></admin-menu>
		<router-view :products='{{$products}}' :users='{{$users}}'></router-view>
	</div>
@endsection


@section('scripts')
<script src="{{URL::asset('js/app.js')}}"></script>
@endsection
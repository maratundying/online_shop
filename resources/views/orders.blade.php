@php
	$counter=0;
@endphp

@extends('layouts/profilelayout')

@section('title')
	<title>My orders</title>
@endsection

@section('css')
	<style>
		table td,th{
			padding:5px;
			text-align: center;
		}

		table{
			margin-top: 10px;
		}

		textarea{
			resize: none;
			/*width:270px;*/
		}

		#content{
			display: flex;
			justify-content: center;
		}

		#feed{
			display: flex;
			align-items: center;
		}
		
	</style>
@endsection

@section('content')
<div id="content" class="table-responsive container">
@if(count($orders)>0)
	<table border="1" class="table-bordered">
		<thead>
			<tr>
				<th>№</th>
				<th>Product</th>
				<th>Count</th>
				<th>Price(pt)</th>
				<th>Date</th>
				<th>Feedback</th>
			</tr>
		</thead>
	@foreach($orders as $order)
		@php
			$counter++
		@endphp
		<tbody>
		<tr data-productid="{{$order->get_data[0]['id']}}">
			<td>{{$counter}}</td>
			<td><a href="{{URL::to('item'.'/'.$order->get_data[0]['id'])}}">{{$order->get_data[0]['name']}}</a></td>
			<td>{{$order->count}}</td>
			<td>{{$order->get_data[0]['price']}}$</td>
			<td>{{$order->created_at->format('d/m/Y H:i:s')}}</td>
			<td id="feed"><textarea name="" placeholder="Your thoughts about the product" class="feedback"></textarea> <button>Share</button></td>
		</tr>
	@endforeach
		</tbody>
	</table>
		@else
			
		<div class="alert alert-danger" style="display:flex;justify-content:center;width: 100%">
			Nothing to show
		</div>
@endif
</div>
@endsection

@section('scripts')
	<script src="{{URL::asset('js/orders_script.js')}}"></script>
@endsection
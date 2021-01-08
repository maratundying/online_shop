@extends('layouts/profilelayout')

@section('title')
	<title>{{$product->name}}</title>
@endsection

@section('css')
	<link rel="stylesheet" href="{{URL::asset('css/item_styles.css')}}">
@endsection

@section('content')

@if(Session::has('foradministrator'))
<div class="alert alert-danger">
	<p align="center">{{Session::get('foradministrator')}}</p>
</div>
@endif
	<div id="content" data-id='{{$product->id}}'>
		<div id="content_body">
			<!-- modali forma -->
			@if(count($product->image_child)>0)
				<div id="photosShow"><img src="{{URL::asset($product->image_child[0]['photo'])}}" alt=""></div>
			<div id="photos">
				@foreach($product->image_child as $image)
					<img class="product_photo" src="{{URL::asset($image['photo'])}}" alt="">
				@endforeach	
			</div>

				@else
					<img src="https://pngimage.net/wp-content/uploads/2018/06/none-png-8.png" alt="">	
			@endif

			<div id="product_data">
				<i class="fa fa-shopping-cart addtobasket" title="Add to basket" aria-hidden="true"></i>
				<i class="fa fa-star-o addToFavorites" title='Add to favorites' id="addToFavorites" aria-hidden="true"></i>
				<div id='basketDiv'></div>
				<h3>{{$product->name}}</h3>
				<strong> {{$product->price}}$ </strong>
				<p>{{$product->description}}</p>
				<h5 id="productCount"><strong>{{$product->count}}</strong> <b>pieces</b></h5>
			</div>

			<div id="buttons">
				@if($product->parent_user->id==Session::get('userId'))
					<button class="btn btn-success" data-toggle="modal" data-target="#myModal2">Change</button>
					<button class="btn btn-danger delete_product_button">Delete this product</button>
				@endif
			</div>

			<div id="feedback">
				@if(count($feedbacks)>0)
					@foreach($feedbacks as $feedback)
						<div class="thisFeedback">
							<div id="userData">
								<span id="data">{{$feedback->get_user['name'] }}   {{$feedback->get_user['surname']}}</span>
								<span id="date">{{$feedback->created_at}}</span>
							</div>
							<p>
								{{$feedback->feedback}}
							</p>
						</div>
					@endforeach
				@endif
			</div>
		</div>

		<div id="content_user_data">
			<img src="{{URL::asset($product->parent_user['image'])}}" alt="">
			<strong>{{$product->parent_user['name']}} {{$product->parent_user['surname']}}</strong>
			<p><i class="fa fa-phone" aria-hidden="true"></i>{{$product->parent_user['phone']}}</p>
			@if(Session::get('userId')!=$product->parent_user['id'])
			<button class="btn btn-success" id="writeMessage" data-user="{{$product->parent_user['id']}}" data-product="{{$product->id}}" data-toggle="modal" data-target="#myModal1">Write message</button>
			@endif
			<a href="{{URL::to('user'.'/'.$product->parent_user['id'])}}">User products</a>
		</div>
	</div>

<!-- The Modal -->
<div class="modal" id="myModal2">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Change product</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
      	

    	<form id="edit_form" style='width:400px;text-align: center;' enctype="multipart/form-data">
    		<input type="hidden" name="productid" value="{{$product->id}}">
			{{csrf_field()}}
			<input type="text" name="name" class="form-control" placeholder="Name" value="{{$product->name}}">
			<input type="text" name="price" class="form-control" placeholder="Price"value="{{$product->price}}">
			<input type="text" name="count" class="form-control" placeholder="Count" value="{{$product->count}}">
			<textarea name="description" oninput="auto_grow(this)" class="form-control" placeholder="Description" style="resize: none">{{$product->description}}</textarea><br>
			<input type="file" name="images[]" multiple>
		</form>  
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
		<button class="btn btn-success" id="changeButton" data-dismiss="modal" type="button">Change</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div id="myModal1" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><strong>{{$product->name}}</strong> - {{$product->parent_user['name']}} {{$product->parent_user['surname']}}</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
	   		<label for="comment" >Message:</label>
     		<textarea class="form-control" rows="5" id="messageInput" style="resize: none"></textarea>
	    </div>
      </div>
      <div class="modal-footer">
      	<button id="sendMessage" type="button" class="btn btn-success" data-dismiss="modal">Send</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
@endsection

@section('scripts')
<script src="{{URL::asset('js/item_script.js')}}"></script>
@endsection
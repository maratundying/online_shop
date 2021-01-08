function auto_grow(element){
    element.style.height="5px";
    element.style.height=(element.scrollHeight)+"px";
}

$(document).on('click','.product_photo',function(){
	$("#photosShow").empty()
	$("#photosShow").append(`<img src="${$(this).attr('src')}">`)
})


$("#changeButton").click(function(){
	let data=new FormData(document.getElementById('edit_form')) //aranc jquery-i,jquery-ov hnaravor che
	$("#errors").remove()
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
		}
	});

	
	$.ajax({
		url:'/changeProductData',
		type:"post",
		processData:false,
		contentType:false,
		data:data,
		success:(r)=>{
			console.log(r)
			$("#product_data").children('h3').empty().append(`${r.name}`)
			$("#product_data").children('strong').empty().append(`${r.price}$`)
			$("#product_data").children('p').empty().append(`${r.description}`)
			$("#productCount").children('strong').empty().append(`${r.count}`)
		},
		error:(r)=>{
			console.log(r.responseText)
			var errors = $.parseJSON(r.responseText).errors;
				let div=$(`<div id="errors" class="alert alert-danger" ></div>`)
				let ul=$(`<ul align='center'></ul>`)
				$.each(errors, function(key, value) {
					ul.append(`<li>${this[0]}</li>`)
				});
				div.append(ul)
				$(".modal-body").prepend(div)
		}
	})
})
















$(document).on('click','.delete_product_button',function(){
	let product_id=$("#content").data('id')
	console.log(product_id)
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
		}
	});

	$.ajax({
		url:"/deleteProduct",
		type:'post',
		data:{product_id}, 
		success:(r)=>{
			location.href='/myproducts'
		}
	})
})

$(document).on('click','#addToFavorites',function(){
	let product_id=$("#content").data('id');
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
		}
	});

	$.ajax({
		url:'/addToFavorites',
		type:'post',
		data:{product_id},
		success:(r)=>{
			$(this).remove()
			$("#product_data").prepend(`<i id='removeFromFavorites' class="fa fa-star addToFavorites" title='Remove from favorites' aria-hidden="true"></i>`)
		}
	})
})

$(document).on('click','#removeFromFavorites',function(){
	let favorite_id=$('#favoriteId').val();
	console.log(favorite_id)
	$(this).remove()
	$("#product_data").prepend(`<i class="fa fa-star-o addToFavorites" title='Add to favorites' id="addToFavorites" aria-hidden="true"></i>`)
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
		}
	});

	$.ajax({
		url:'/removeFromFavoritesItem',
		type:'post',
		data:{favorite_id},
		success:(r)=>{
			console.log(r)
			$(this).remove()
			$("#product_data").prepend(`<i class="fa fa-star-o addToFavorites" title='Add to favorites' id="addToFavorites" aria-hidden="true"></i>`)
		}
	})
})

$(".addtobasket").click(function(){
	let product_id=$("#content").data('id')
	$("#basketDiv").empty()
	$("#basketDiv").append(`
		<span>
			<i class="fa fa-minus minus" aria-hidden="true"></i>
			<input type="number" id='basketCount' min='1' value='1'>
			<i class="fa fa-plus plus" aria-hidden="true"></i><br>
		</span>
		<i class="fa fa-check" id='addToBasketButton' aria-hidden="true"></i>
		<i class="fa fa-times" id='cancel' aria-hidden="true"></i>
		`)
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
		}
	});
})

$(document).ready(function(){
	let product_id=$("#content").data('id')

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
		}
	});

	$.ajax({
		url:'/checkingForFavorite',
		type:'post',
		data:{product_id},
		success:(r)=>{
			if(Object.keys(r).length!=0){
				$("#content").prepend(`<input type="hidden" id='favoriteId' value=${r.id}>`)
				$("#addToFavorites").remove()
				$("#product_data").prepend(`<i id='removeFromFavorites' class="fa fa-star addToFavorites" title='Remove from favorites' aria-hidden="true"></i>`)
			}
		}
	})
})

$(document).on('click','.plus',function(){
	let productCount=+$("#productCount strong").text()
	let count=+$("#basketCount").val()+1
	if(count<=productCount){
		$("#basketCount").val(count)
	}

	if(count>productCount){
		$("#basketCount").val(productCount)
	}

	if(count<1){
		$("#basketCount").val(1)
	}
})

$(document).on('click','.minus',function(){
	let productCount=+$("#productCount strong").text()
	let count=+$("#basketCount").val()-1
	if(count>0){
		$("#basketCount").val(count)
	}

	if(count>productCount){
		$("#basketCount").val(productCount)
	}

	if(count<1){
		$("#basketCount").val(1)
	}
})

$(document).on('click','#addToBasketButton',function(){
	let basketCount=$('#basketCount').val()
	let productCount=+$("#productCount strong").text()
	if(basketCount<=productCount){		
		let product_id=$("#content").data('id')
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
			}
		});	

		$.ajax({
			url:'/addToBasket',
			type:'post',
			data:{product_id,productCount,basketCount},
			success:(r)=>{
				$("#basketDiv").empty()
			}
		})	
	}
})

$(document).on('click','#cancel',function(){
	$("#basketDiv").empty()
})

$(document).on('click','#sendMessage',function(){
	let message=$('#messageInput').val()
	let user_id=$('#writeMessage').data('user')
	let product_id=$('#writeMessage').data('product')

	if(message.length>0){
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
			}
		});

		$.ajax({
			url:'/sendMessage',
			type:'post',
			data:{message,user_id,product_id},
			success:(r)=>{
				console.log(r)
			}
		})		
	}
})
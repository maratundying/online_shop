$(document).on('click','.plus',function(){
	let basketProductCount=+$(this).parents('.thisProduct').data('productcount')
	let productCount=+$(this).parents('.thisProduct').data('count')
	let count=+$(this).parents('.thisProduct').children('#buttons').children('#basketCount').val()+1
	let basket_id=$(this).parents('.thisProduct').data('id')
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
		}
	});

	if(count<=productCount){
		$(this).parents('.thisProduct').children('#buttons').children('#basketCount').val(count)

		$.ajax({
			url:'/plusBasketCount',
			type:'post',
			data:{basket_id},
			success:(r)=>{
				console.log(r)
				$(this).parents('.thisProduct').children('.price').children('b').empty().append(`${r.price*count}`)
			}
		})
	}

	if(count<1){
		$(this).parents('.thisProduct').children('#buttons').children('#basketCount').val(1)
	}
})

$(document).on('click','.minus',function(){
	let productCount=$(this).parents('.thisProduct').data('count')
	let count=+$(this).parents('.thisProduct').children('#buttons').children('#basketCount').val()-1
	let basket_id=$(this).parents('.thisProduct').data('id')

	if(count>0){
		$(this).parents('.thisProduct').children('#buttons').children('#basketCount').val(count)
		$.ajax({
			url:'/minusBasketCount',
			type:'post',
			data:{basket_id},
			success:(r)=>{
				console.log(r)
				console.log(count)
				$(this).parents('.thisProduct').children('.price').children('b').empty().append(`${r.price*count}`)
			}
		})
	}

	if(count>productCount){
		$(this).parents('.thisProduct').children('#buttons').children('#basketCount').val(count)
	}

	if(count<1){
		$(this).parents('.thisProduct').children('#buttons').children('#basketCount').val(1)
	}
})

$(document).on('click','#removeFromCard',function(){
	let product_id=$(this).parents('.thisProduct').data('id');
	let count=$(this).parents('.thisProduct').children('#buttons').children('#basketCount').val()

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
		}
	});

	$.ajax({
		url:'/removeFromCard',
		type:'post',
		data:{product_id,count},
		success:(r)=>{
			$(this).parents('.thisProduct').remove();
		}
	})
})


$(".buyy").click(function(){
	var product_id=+$(this).parents('.thisProduct').data('productid')
	var basket_id=+$(this).parents('.thisProduct').data('id')
	var count=+$(this).parents('.thisProduct').children('#buttons').children('#basketCount').val();
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
		}
	});

	function ajax1(){
		return new Promise((ok,error)=>{$.ajax({
				url:'/checkProductCount',
				type:'post',
				data:{product_id},
				success:(r)=>{
					return ok({count:r.count})
				}
			})
		})
	}
	function ajax2(){
		return new Promise((ok,error)=>{$.ajax({
				url:'/pricetosession',
				type:'post',
				data:{product_id,basket_id,count},
				success:(r)=>{
					$(this).parents('.thisProduct').remove();
					window.location.href='/stripe'
				}
			})
		})
	}

	ajax1().then((r)=>{
		if(r.count>=count && count>0){
			return ajax2();
		}
		else{
			$(this).parents('.thisProduct').prepend(`<div style="position:absolute" class='alert alert-danger'>Invalid count of product</div>`)
		}
	})
})

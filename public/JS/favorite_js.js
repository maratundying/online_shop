$(".removeFromFavorites").click(function(){
	let favorite_id=$(this).parent().data('id')

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
		}
	});

	$.ajax({
		url:'/removeFromFavorites',
		type:'post',
		data:{favorite_id},
		success:(r)=>{
			$(this).parent().remove()
		}
	})
})


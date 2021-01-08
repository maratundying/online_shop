$("button").click(function(){
	let feedback=$(this).parent().children('.feedback').val();
	let product_id=+$(this).parents('tr').data('productid')
	if(feedback.length>0){
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
			}
		});

		$.ajax({
			url:'/addFeedback',
			type:'post',
			data:{feedback,product_id},
			success:(r)=>{
				$('.feedback').val('')
			}
		})
	}
})
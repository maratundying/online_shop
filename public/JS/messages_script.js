$("#sendMessage").click(function(){
	let message=$("#messageInput").val();

	if(message.length>0){
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
			}
		});

		$.ajax({
			url:'/sendNewMessage',
			type:'post',
			data:{message},
			success:(r)=>{
				$("#messageInput").val('')
			}
		})
	}
})

$("#respond").click(function(){
	let message=$("#responceInput").val()

	if(message.length>0){
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
			}
		});

		$.ajax({
			url:'/sendResponce',
			type:'post',
			data:{message},
			success:(r)=>{
				$("#responceInput").val('')
			}
		})
	}
})
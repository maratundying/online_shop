$(document).on('click',"#changeData",function(){
	var changeName=$("#changeName").val()
	var changeSurname=$("#changeSurname").val()
	var changeAge=$("#changeAge").val()
	var changeEmail=$("#changeEmail").val()
	console.log(changeAge)

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
		}
	});

	$.ajax({
		url:'/changeData',
		type:'post',
		data:{changeName,changeSurname,changeAge,changeEmail},
		success:(r)=>{
			$("#user_data").children('span').remove()
			$("#user_data").append(`<span>${changeName}</span>`)
			$("#myModal").modal('hide')
		},
		errors:(r)=>{
			console.log(r)
		}
	})
})
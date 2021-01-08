$("#recoveryButton").click(function(){
	$(".alert-danger").remove()
	let email=$("#email").val();
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
		}
	});

	$.ajax({
		url:'/recoverMessage',
		type:'post',
		data:{email},
		success:(r)=>{
			console.log(r)
			if(r=='ok'){
				$(".container form").append(`
					<div class="form-group">
						<label for="code">Code</label>
						<input type="text" name="code" id="code" class="form-control" placeholder="Code sent to your email">
					</div>
				`)

				$("#buttons").prepend(`
					<button id='sendCode' class="btn btn-primary">Recover</button>
				`)
				$(this).remove()
			}

			else{
				$('body').prepend(`
					<div class="alert alert-danger" align='center'>
						${r}
					</div>
				`)
			}
		}
	})
})

$(document).on('click','#sendCode',function(){
	$(".alert-danger").remove()
	
	let code=$("#code").val();

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
		}
	});

	$.ajax({
		url:'/sendCode',
		type:'post',
		data:{code},
		success:(r)=>{
			if(r=='ok'){
				$(".container form").append(`
					<div class="form-group">
						<label for="password">New password</label>
						<input type="password" name="password" id="password" class="form-control" placeholder="New password">
					</div>

					<div class="form-group">
						<label for="confirm">Confirm</label>
						<input type="password" name="confirm" id="confirm" class="form-control" placeholder="Confirm password" >
					</div>
				`)

				$("#buttons").prepend(`
					<button id='changePassword' class="btn btn-primary">Recover</button>
				`)
				$(this).remove()
			}

			else{
				$('body').prepend(`
					<div class="alert alert-danger" align='center'>
						${r}
					</div>
				`)
			}
		}
	})	
})

$(document).on('click','#changePassword',function(){
	$("#form").submit();
})
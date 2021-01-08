$("#search-input").on('keypress',function(e) {
    if(e.which == 13) {
    $("#nothing").remove()
	$("#content").empty();
	let input=$("#search-input").val();
    	$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
			}
		});

    	$.ajax({
    		url:'/search',
    		type:'post',
    		data:{input},
    		success:(r)=>{
    			console.log(r)
                if(r.length>0){
    			for(let i in r){
					let thisProduct=$(`<div class="thisProduct" data-id='${r[i].id}'>`)
					let div=$(`<div>
						<a href='item/${r[i].id}'>${r[i].name}</a>
						<strong>${r[i].price}$ </strong>
						<p>${r[i].description}</p>
					</div>`)
    				thisProduct.append(div)
    				if(r[i].photos){
    					thisProduct.prepend(`<img src="${r[i].photos}" alt="" />`)
    				}

    				else{
    					thisProduct.prepend(`<img src="https://pngimage.net/wp-content/uploads/2018/06/none-png-8.png" alt="" />`)
    				}
    				$('#content').append(thisProduct)
    			}
            }
            else{
                let nothingsDiv=$(`
                        <div id='nothing' class="alert alert-danger" style="display:flex;justify-content:center;width: 100%">
                            The search has returned no result
                        </div>
                    `)
                $('#content').append(nothingsDiv)

            }
    		}
    	})
    }
});


$(document).on('click',"#categories>li",function(){
    let id=$(this).data('id')
    $("#content").empty();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
        }
    }); 
            
    $.ajax({
        url:'categoryProduct',
        type:'post',
        data:{id},
        success:(r)=>{
            if(r.length>0){
                for(let i in r){
                        let thisProduct=$(`<div class="thisProduct" data-id='${r[i].id}'>`)
                        let div=$(`<div>
                            <a href='item/${r[i].id}'>${r[i].name}</a>
                            <strong>${r[i].price}$ </strong>
                            <p>${r[i].description}</p>
                        </div>`)
                        thisProduct.append(div)
                        if(r[i].photos){
                            thisProduct.prepend(`<img src="${r[i].photos}" alt="" />`)
                        }

                        else{
                            thisProduct.prepend(`<img src="https://pngimage.net/wp-content/uploads/2018/06/none-png-8.png" alt="" />`)
                        }
                        $('#content').append(thisProduct)
                    }
            }
            else{
                $('#content').append(`<div class='container alert alert-danger' align='center'>Nothing to show</div>`)
            }
        }
    })
})
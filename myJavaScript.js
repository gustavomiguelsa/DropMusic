function registerFunction(){
		console.log("teste1");
		var username_=document.getElementById("in_username_reg").value;
		var birthday_=document.getElementById("in_ddn_reg").value;
		console.log(username_);
		console.log(birthday_);
		$.ajax({
			url:'/register.php',
			type:'POST',
			dataType: 'json',
			data:{
				b: birthday_,
				u: username_
			}


		}).done(function(data){

			console.log("teste2");			
		});
	}



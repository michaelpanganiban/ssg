$("#sign-in").submit(function(e){
	e.preventDefault();
	var username = $("#username").val();
	var password = $("#password").val();
	$.post("MainController/login", {username:username, password:password}, function(r){
		if(r == 1)
		{
			alertify.success("Successfully login");
			setTimeout(function(e){
				window.location = "MainController/home";
			}, 1500);
		}
		else
		{
			alertify.error("Invalid username/password");
		}
	});		
});
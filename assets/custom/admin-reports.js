$("#auth-pdf").click(function(e){
	var from = $("#from").val();
	var to 	 = $("#to").val();
	var user = $("#user").val();
	window.open("authLogs?from=" + from + "&to=" + to + "&user="+ user + "&save=pdf",  "_blank", "width=1000, height=600");
});

$("#auth-excel").click(function(e){
	var from = $("#from").val();
	var to 	 = $("#to").val();
	var user = $("#user").val();
	window.open("authLogs?from=" + from + "&to=" + to + "&user="+ user + "&save=excel",  "_blank");
});

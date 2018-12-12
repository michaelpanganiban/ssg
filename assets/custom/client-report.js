$("#hc-pdf").click(function(e){
	var from = $("#from").val();
	var to 	 = $("#to").val();
	var client = $("#client").val();
	var div_id = $("#div_id").val();
	window.open("headcountReport?from=" + from + "&to=" + to + "&client="+ client + "&div_id=" + div_id + "&save=pdf",  "_blank", "width=1000, height=600");
});

$("#hc-excel").click(function(e){
	var from = $("#from").val();
	var to 	 = $("#to").val();
	var client = $("#client").val();
	var div_id = $("#div_id").val();
	window.open("headcountReport?from=" + from + "&to=" + to + "&client="+ client + "&div_id=" + div_id + "&save=excel",  "_blank");
});

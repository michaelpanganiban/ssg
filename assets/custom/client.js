$("#add-client").click(function(e){
	window.open("addClient", "target=_blank");
});

$("#table-add").click(function(e){
	var count = $(".client-line").length;
	var client_clone = $(".client-line:first").clone();
	client_clone.attr('id', 'client-line' + (count + 1));
	client_clone.find('span').attr('id', 'remove-line' + (count + 1));
	client_clone.find('span').attr('data-count', + (count + 1));
	$("#append-client-line").append(client_clone);
	count++;
	clearData(client_clone);
	$(".date-picker").datepicker({format:'yyyy-m-d'});	
}); //add line

$(document).on('click', '.remove-line', function(e){
	var count = $(this).data('count');
	$("#client-line"+count).remove();
}); //remove line

$("#proceed-add-client").click(function(e){
	var error = 0;
	if(checkFields() == 1)
	{
		alertify.error("Fields marked red are required.");
		error = 1;
	}
	if(checkFieldsLine() == 1)
	{
		alertify.error("Annex field cannot be empty.");
		error = 1;
	}
	if(error == 0)
	{
		Pace.restart();
		Pace.track(function(){
			var client_line = checkFieldsLine();
			var data = {
							'team_name' 		  : $("#client-name").val(),
							'division_id'		  : $("#industry").val(),
							'customer_experience' : $("#customer-exp").val(),
							'back_office' 		  : $("#back-office").val(),
							'F_and_a' 			  : $("#fa").val(),
							'hq' 				  : $("#hq").val(),
							'auth_hc' 			  : $("#hc").val(),
							'tier' 			      : $("#tier").val(),
							'case_study' 		  : $("#case-study").val(),
							'visit' 			  : $("#visit").val(),
							'target_market'		  : $("#target-market").val(),
							'segment'			  : $("#segment").val(),
							'job_desc' 			  : $("#job-desc").val(),
							'address'			  : $("#client-address").val()
						}
			waitingDialog.show('Processing data...', {dialogSize: 'sm', progressType: 'success'});
			$.post("addClient", {client: data, client_line: client_line, add: 'true'}, function(r){
				if(r == 0)
					alertify.success("Client was successfully added.");
				else
					alertify.error("Error adding client. Please try again.");
				waitingDialog.hide();
				setTimeout(function(e){
					location.reload();
				}, 1500);
			});
		});
	}
}); //Proceed adding data to db
//----------------------------------------- END OF ADDING OF CLIENT / START UPDATE OF CLIENT ---------------------------------------------------->

$(".client-each").click(function(e){
	var id = $(this).data('pk');
	window.open("editClient/"+id);
});

$("#proceed-update-client").click(function(e){
	var error = 0;
	if(checkFields() == 1)
	{
		alertify.error("Fields marked red are required.");
		error = 1;
	}
	if(checkFieldsLine() == 1)
	{
		alertify.error("Annex field cannot be empty.");
		error = 1;
	}
	if(error == 0)
	{
		Pace.restart();
		Pace.track(function(){
			waitingDialog.show('Processing data...', {dialogSize: 'sm', progressType: 'success'});
			var client_line = checkFieldsLine();
			var team_id 	= $("#client-name").data('id');
			var data = {
							'team_name' 		  : $("#client-name").val(),
							'division_id'		  : $("#industry").val(),
							'customer_experience' : $("#customer-exp").val(),
							'back_office' 		  : $("#back-office").val(),
							'F_and_a' 			  : $("#fa").val(),
							'hq' 				  : $("#hq").val(),
							'auth_hc' 			  : $("#hc").val(),
							'tier' 			      : $("#tier").val(),
							'case_study' 		  : $("#case-study").val(),
							'visit' 			  : $("#visit").val(),
							'target_market'		  : $("#target-market").val(),
							'segment'			  : $("#segment").val(),
							'job_desc' 			  : $("#job-desc").val(),
							'address'			  : $("#client-address").val(),
							'ref_no'			  : $("#client-name").data('ref')
						}
			$.post("editClient", {client: data, client_line: client_line, edit: 'true', team_id:team_id}, function(r){
				if(r == 1)
					alertify.success("Client was successfully updated.");
				else
					alertify.error("Error updating client. Please try again.");
				waitingDialog.hide();
				setTimeout(function(e){
					location.reload();
				}, 1500);
			});
		});
	}
}); //edit client info 

$(".start-date").change(function(e){
	var s_date = $(this).val().split("-");
	var id 	   = $(this).data('pk');
	var e_date = $(".c-line-"+id).find(".expiry-date").val().split("-");
	var diff   = s_date[1] - e_date[1];
	$("tr").find(".remaining-months-" + id).val(Math.abs(diff));
});

$(".expiry-date").change(function(e){
	var s_date = $(this).val().split("-");
	var id 	   = $(this).data('pk');
	var e_date = $(".c-line-"+id).find(".start-date").val().split("-");
	var diff   = s_date[1] - e_date[1];
	$("tr").find(".remaining-months-" + id).val(Math.abs(diff));
});

$(".remove-line-edit").click(function(e){
	if($("input[name^='annex']").length == 1)
	{
		alertify.error("This column cannot be removed.");
	}
	else
	{
		var line_id = $(this).data('pk');
		$.confirm({
				    title: 'Warning!',
				    content: 'Remove this column?',
				    type: 'error',
				    icon: 'fa fa-warning',
				    theme:'dark',
				    buttons: {
				    			close: function () {
						        },
						        tryAgain: {
						            text: 'Confirm',
						            btnClass: 'btn-red',
						            action: function()
						            {
							            Pace.restart();
										Pace.track(function(){
							    			$.post("../editClient", {line_id:line_id, remove_line:'true'}, function(r){
							    				if(r == 1)
							    				{
							    					alertify.success("Column was successfully removed.");
							    					setTimeout(function(e){
							    						location.reload();
							    					}, 1500);
							    				}
							    				else
							    				{
							    					alertify.error("Error removing column.");
							    				}
											});
										});
									}
						        }						        
				    		}
				});
	}
}); //delete annex in update client info

$("#table-add-update").click(function(e){
	var id = $(this).data('pk');
	$.post("../editClient", {id:id, add_column:'true'}, function(r){
		location.reload();
	});
}); //add new column 

//-------------------------------------------END OF UPDATE CLIENT / START TARGETS AND ACTUALS-------------------------------------------------------->

$(".add-target").click(function(e){
	var date = new Date();
	if($(this).data('pk') == "")
	{
		var client_id = "";
	}
	else
	{
		var client_id = $(this).data('pk');
	}
	var html = '<section class="content"><div class="row"><div class="form-group col-md-12"><label class="control-label col-md-1">Client:</label><div class="col-md-4"><select class="form-control select2" id="client"></select></div><label class="control-label col-md-1">Month:</label><div class="col-md-3"><select class="form-control select2" id="month"></select></div><label class="control-label col-md-1">Year:</label><div class="col-md-2"><select class="form-control" id="year"><option value="'+(1900 + date.getYear())+'">'+(1900 + date.getYear())+'</option><option value="'+(1900 + date.getYear() + 1)+'">'+(1900 + date.getYear() + 1)+'</option></select></div></div></div><div class="row"><div class="form-group col-md-12"><label class="control-label col-md-1">Target:</label><div class="col-md-4"><input type="number" class="form-control col-md-4" id="target"></div><label class="control-label col-md-1">Add:</label><div class="col-md-3"><input type="radio" class="action" name="action-type" value="Add"></div><label class="control-label col-md-1">Deduct:</label><div class="col-md-2"><input type="radio" class="action" name="action-type" value="Deduct"></div></div></div><hr>';
		html += '<div class="row"><div class="form-group col-md-12"><table class="table"><thead><tr><th class="text-center">Current Function</th><th class="text-center">Billed HC</th><th class="text-center">Cost per Title</th><th class="text-center">Ttl Cost</th><th class="text-center">Hours Worked</th><th class="text-center">Timezone</th><th class="text-center">Shift</th><th class="text-center">Location</th><th><i class="fa fa-2x fa-plus-circle text-success" style="cursor:pointer;" id="add-column-target"></i></th></tr></thead>';
		html += '<tbody id="target-data"><tr class="target-clone"><td><select class="form-control functions" id="func-1" data-pk="1" name="functions[]"><option value="">Select Current Function..</option></select></td><td><input type="number" name="billed[]" class="form-control"></td><td><input type="number" class="form-control" name="cost[]"></td><td><input type="number" class="form-control" name="ttl-cost[]"></td><td><input type="text" class="form-control " name="hours[]"></td><td><select class="form-control" name="timezone[]"><option value="">Select timezone..</option><option value="US">US</option><option value="Manila">Manila</option></select></td><td><select class="form-control " name="shift[]"><option value="">Select shift..</option><option value="Night">Night</option><option value="Day">Day</option></select></td><td><select class="form-control" name="location[]"><option value="">Select Location..</option><option value="Makati">Makati</option><option value="Legazpi">Legazpi</option></select></td><td><i class="fa fa-close fa-2x remove-target text-danger" style="cursor:pointer;"></i></td></tr></tbody></table></div></div></section>';
	BootstrapDialog.show({
        title: 'Manage Targets',
		size: BootstrapDialog.SIZE_WIDE,
        message: html,
        closable: false,
        onshown: function(e)
        {
        	$.post("targetsAndActuals", {joborder_list:"true"}, function(r){
        		var data = jQuery.parseJSON(r);
        		var functions = "<option value=''>Select Current Function...</option><option value='add'>Add Function</option>";
        		$.each(data, function(key, val){
        			functions += "<option value='"+this.joborder_id+"'>"+this.title+"</option>";
        		});
        		functions+="<option value=''>"
        		$(".functions").html(functions);
        	});
	        $(".modal-dialog").css('width', '90%');
	        $("#add-column-target").click(function(e){
	        	var count = $(".target-clone").length;
	        	var clone_target = $(".target-clone:first").clone();
	        	clone_target.attr('id', 'remove-tr-'+(count+1));
	        	clone_target.find('i').attr('id', 'remove-'+ (count + 1));
	        	clone_target.find('.functions').attr('data-pk', (count + 1));
	        	clone_target.find('.functions').attr('id', 'func-'+ (count + 1));
	        	clone_target.find('i').attr('data-pk', count + 1);
	        	$("#target-data").append(clone_target);
	        	clearData(clone_target);
	        });

	       	$(document).on('click', '.remove-target', function(e){
	        	var count = $(this).data('pk');
	        	$("#remove-tr-" + count).remove();
	        });

	        $.post("targetsAndActuals", {client_list:'true'}, function(r){
	        	var data = jQuery.parseJSON(r);
	        	var client = "<option value=''>Select Client..</option>";
	        	$.each(data, function(key, val){
	        		if(client_id == this.team_id)
	        		{
	        			client += "<option selected value='"+this.team_id+"'>"+this.team_name+"</option>";
	        			$("#client").attr('disabled','true').trigger('change');
	        		}
	        		else
	        			client += "<option value='"+this.team_id+"'>"+this.team_name+"</option>";
	        	});
	        	$("#client").html(client).select2();
	        });

	        $(document).on('change','.functions', function(e){
	        	if($(this).val() == "add")
	        	{
	        		var count_id = $(this).data('pk');
	        		BootstrapDialog.show({
	        			title: 'Add Function',
	        			message: '<center><input type="text" class="form-control" placeholder="Add new function" id="add-function-input"></center>',
	        			closable: false,
	        			buttons: [
	        						{
	        							label: '<i class="fa fa-close"></i>&nbsp;&nbsp;Close',
								            cssClass: 'btn btn-sm btn-default pull-left',
								            action: function(dialog) {
								               dialog.close();
								               $("#func-"+count_id).val("");
								            }
	        					 	},
	        					 	{
	        					 		label: '<i class="fa fa-plus-circle"></i>&nbsp;&nbsp; Add',
							            cssClass: 'btn btn-sm btn-primary pull-right',
							            id: 'proceed-add-func-btn',
							            action: function(dialog) 
							            {
							            	var new_function = $("#add-function-input").val();
								            if(new_function != "")
								            {
								            	$("#proceed-add-func-btn").attr('disabled', 'true');
								            	$.post("targetsAndActuals", {new_function:new_function, add_function:'true'}, function(r){
								            		if(r != 0)
								            		{
								            			$("#func-"+count_id).append("<option selected value='"+r+"'>"+new_function+"</option>");
								            			dialog.close();
								            		}
								            		else
								            			alertify.error("Error adding new function.");
								            	});
							            	}
							            	else
							            	{
							            		alertify.error("Job name cannot be empty.");
							            	}
							            }
	        					 	}
	        					 ],
	        		});
	        	}
	        });

	        var month = [ "January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December" ];
	        var list_month = "<option value='null'>Select Month...</option>";
        	for(var i = 0; i < month.length; i++)
        	{
        		list_month += "<option value='"+month[i]+"'>"+month[i]+"</option>";
        	}
        	$("#month").html(list_month).select2();
        	$(".bootstrap-dialog").removeAttr("tabindex");
        },
        buttons: [
        			{
			            label: '<i class="fa fa-close"></i>&nbsp;&nbsp;Close',
			            cssClass: 'btn btn-sm btn-default pull-left',
			            action: function(dialog) {
			               dialog.close();
			               location.reload();
			            }
			        }, 
			        {
			            label: '<i class="fa fa-check-circle"></i>&nbsp;&nbsp; Proceed',
			            cssClass: 'btn btn-sm btn-primary pull-right',
			            id: 'proceed-target-btn',
			            action: function(dialog) 
			            {
			        		var error    = 0;
			        		var total_hc = 0;
			        		$("input[name^='billed[]'").each(function(e){
								if($(this).val() != "")
								{
									total_hc += parseInt($(this).val());
								}
							});
			        		if($("#target").val() != total_hc)
			        		{
			        			alertify.error('Target must match the column count.');
			        			error = 1;
			        		}

			        		if(checkFieldsTarget() == 1)
			        		{
			        			alertify.error("All fields are required.");
			        			error = 1;
			        		}
			        		if(getTargetData() != 1)
			        		{
			        			var data_target = getTargetData();
			        		}
			        		else
			        		{
			        			alertify.error("All fields are required.");
			        			error = 1;
			        		}
			        		if(error == 0)
			        		{
			        			$("#proceed-target-btn").attr('disabled','true');
			        			waitingDialog.show('Processing data...', {dialogSize: 'sm', progressType: 'success'});
			        			Pace.restart();
			        			Pace.track(function(){
			        				var client = {
			        								'team_id': $("#client").val(),
			        								'year' 	 : $("#year").val(),
			        								'action' : $("input[name='action-type']:checked").val()
			        							 };
			        					if($("input[name='action-type']:checked").val() == "Deduct")
			        						var target = '-'+$("#target").val();
			        					else
			        						var target = $("#target").val();
			        					client[$("#month").val()] = target;
			        				var client2 = {
			        								'team_id': $("#client").val(),
			        								'year' 	 : (parseInt($("#year").val()) - 1),
			        								'action' : ""
			        							  }; 
			        				$.post("targetsAndActuals", {add:'true', client:client, line: data_target, client2:client2, id:$("#client").val()}, function(r){
			        					if(r == 1)
			        					{
			        						alertify.success("Target was successfully added.");
			        						setTimeout(function(e){
			        							location.reload();
			        						}, 1500);
			        					}
			        					else
			        					{
			        						alertify.error("Error adding target.");
			        					}
			        					waitingDialog.hide();
			        				});
			
			        			});
			        		}
			        	}
        			}
        		]
    });
}); 

$(".target-each").click(function(e){
	var id 	 = $(this).data('pk');
	var name = $(this).data('name');
	var html = '<section class="content"><div class="row"><h4 style="font-family: Century Gothic; font-size:20px; color: #272727; font-weight: light; text-align:center;">'+name+'</h4><br><table class="table table-bordered"><thead><tr style="background-color: #d7d7d8;" ><th class="text-center">Current Function</th><th class="text-center">Billed HC</th><th class="text-center">Cost per Title</th><th>TTL Cost</th><th class="text-center">Hours Worked</th><th class="text-center">Timezone</th><th class="text-center">Shift</th><th class="text-center">Location</th></tr></thead><tbody id="append-body"></tbody></table></div></section>';
	BootstrapDialog.show({
		title: 'Detailed List',
		message: html,
		size: BootstrapDialog.SIZE_WIDE,
		onshown: function()
		{
			$(".modal-dialog").css('width', '90%');
			waitingDialog.show('Fetching data...', {dialogSize: 'sm', progressType: 'success'});
			Pace.restart();
			Pace.track(function(){
				$.post("targetsAndActuals", {id:id, get_detailed: "true"}, function(r){
					// console.log(r);
					var data 		 = jQuery.parseJSON(r);
					var text 		 = "";
					var total_billed = 0;
					var total_cost 	 = 0;
					$.each(data, function(key, val){
						text += "<tr><td>"+this.title+"</td><td align='right'>"+this.billed_hc+"</td><td  align='right'>$ "+this.cost_per_title+"</td><td  align='right'>"+this.ttl_cost+"</td><td  align='right'>"+this.hours_work+"</td><td  align='right'>"+this.timezone+"</td><td  align='right'>"+this.shift+"</td><td  align='right'>"+this.location+"</td></tr>";
						total_billed += parseInt(this.billed_hc);
						if(this.billed_hc > 0)
							total_cost 	 += parseInt(this.cost_per_title);
					});
						text += "<tr style='background-color: #d7d7d8;'><td><b>Total</b></td><td align='right'><b>"+total_billed+"</b></td><td  align='right'><b>$ "+total_cost+"</b></td><td  align='right'></td><td  align='right'></td><td  align='right'></td><td  align='right'></td><td></td></tr>";
					$("#append-body").append(text);
				});
			});
			waitingDialog.hide();
		},
		buttons: [	
					{
						label: '<i class="fa fa-close"></i>&nbsp;&nbsp;Close',
			            cssClass: 'btn btn-sm btn-default pull-left',
			            action: function(dialog) {
			               dialog.close();
			            }
					}
				]

	});
});	




//------- FUNCTION DEFINITION AREA ------------//

function clearData(clone)
{
	clone.find('input').val('');
  	clone.find('select').val('');
  	clone.find('textarea').val('');
}

function checkFields()
{
	var error = 0;
	if($("#client-name").val() == "" || $("#client-name").val() == undefined)
	{
		$("#client-name").css('border', '1px solid red');
		error = 1;
	}

	if($("#industry").val() == "" || $("#industry").val() == undefined)
	{
		$("#industry").siblings(".select2-container").css('border', '1px solid red');
		error = 1;
	}

	if($("#hc").val() == "" || $("#hc").val() == undefined)
	{
		$("#hc").css('border', '1px solid red');
		error = 1;
	}

	if($("#hq").val() == "" || $("#hq").val() == undefined)
	{
		$("#hq").css('border', '1px solid red');
		error = 1;
	}

	if($("#tier").val() == "" || $("#tier").val() == undefined)
	{
		$("#tier").siblings(".select2-container").css('border', '1px solid red');
		error = 1;
	}

	if($("#segment").val() == "" || $("#segment").val() == undefined)
	{
		$("#segment").css('border', '1px solid red');
		error = 1;
	}

	if($("#job-desc").val() == "" || $("#job-desc").val() == undefined)
	{
		$("#job-desc").css('border', '1px solid red');
		error = 1;
	}
	return error;
}

function checkFieldsLine()
{
	var annex = Array();
	var s_date= Array();
	var e_date= Array();
	var status= Array();
	var next  = Array();
	var remark= Array();
	var data  = Array();
	var id    = Array();
	var error = 0;
	$("input[name^='annex']").each(function(e){
		if($(this).val() != "")
		{
			annex.push($(this).val());
			id.push($(this).data('pk'));
		}
		else
		{
			error = 1;
			$(this).css('border', '1px solid red');
		}
	});
	$("input[name^='s_date']").each(function(e){
		s_date.push($(this).val());
	});
	$("input[name^='e_date']").each(function(e){
		e_date.push($(this).val());
	});
	$("select[name^='status']").each(function(e){
		status.push($(this).val());
	});
	$("input[name^='next-step']").each(function(e){
		next.push($(this).val());
	});
	$("input[name^='remarks']").each(function(e){
		remark.push($(this).val());
	});
	for(var i = 0; i < annex.length; i++)
	{
		data.push(
					{
						'annex' 	  : annex[i],
						'start_date'  : s_date[i],
						'expiry_date' : e_date[i],
						'status'	  : status[i],
						'next_step'	  : next[i],
						'remarks'	  : remark[i],
						'team_line_id': id[i]
					}
				);
	}
	if(error == 1)
		return error;
	return data;
}

function checkFieldsTarget()
{
	var error = 0;
	if($("#client").val() == "")
	{
		$("#client").siblings(".select2-container").css('border', '1px solid red');
		error = 1;
	}
	if($("#month").val() == "null")
	{
		$("#month").siblings(".select2-container").css('border', '1px solid red');
		error = 1;
	}
	if($("#target").val() == "" || $("#target").val() < 1)
	{
		$("#target").css('border', '1px solid red');
		error = 1;
	}
	if($("input[name='action-type']:checked").val() == undefined)
	{
		error = 1;
	}
	return error;
}

function getTargetData()
{
	var error 	  = 0;
	var functions = Array();
	var billed 	  = Array();
	var cost 	  = Array();
	var ttl_cost  = Array();
	var hours 	  = Array();
	var timezone  = Array();
	var shift     = Array();
	var location  = Array();
	var data      = Array();

	$("select[name^='functions[]'").each(function(e){
		if($(this).val() == "" || $(this).val() == 'add')
		{
			error = 1;
			$(this).css('border', '1px solid red');
		}
		else
			functions.push($(this).val());
	});

	$("input[name^='billed[]'").each(function(e){
		if($(this).val() == "")
		{
			error = 1;
			$(this).css('border', '1px solid red');
		}
		else
		{
			if($("input[name='action-type']:checked").val() == "Deduct")
				billed.push('-'+$(this).val());
			else
				billed.push($(this).val());
		}
	});

	$("input[name^='cost[]'").each(function(e){
		if($(this).val() == "")
		{
			error = 1;
			$(this).css('border', '1px solid red');
		}
		else
			cost.push($(this).val());
	});

	$("input[name^='ttl-cost[]'").each(function(e){
		if($(this).val() == "")
		{
			error = 1;
			$(this).css('border', '1px solid red');
		}
		else
			ttl_cost.push($(this).val());
	});

	$("input[name^='hours[]'").each(function(e){
		if($(this).val() == "")
		{
			error = 1;
			$(this).css('border', '1px solid red');
		}
		else
			hours.push($(this).val());
	});

	$("select[name^='timezone[]'").each(function(e){
		if($(this).val() == "")
		{
			error = 1;
			$(this).css('border', '1px solid red');
		}
		else
			timezone.push($(this).val());
	});

	$("select[name^='shift[]'").each(function(e){
		if($(this).val() == "")
		{
			error = 1;
			$(this).css('border', '1px solid red');
		}
		else
			shift.push($(this).val());
	});

	$("select[name^='location[]'").each(function(e){
		if($(this).val() == "")
		{
			error = 1;
			$(this).css('border', '1px solid red');
		}
		else
			location.push($(this).val());
	});

	if(error != 1)
	{
		for(var i = 0; i < functions.length; i++)
		{
			data.push(
						{
							'function' : functions[i],
							'billed'   : billed[i],
							'cost'     : cost[i],
							'ttl_cost' : ttl_cost[i],
							'hours'    : hours[i],
							'timezone' : timezone[i],
							'shift'    : shift[i],
							'location' : location[i]
						}
					);
		}
		return data;
	}
	return error;
}


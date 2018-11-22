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
$("#attachment").change(function(e){
	$("#file-name").html($("#attachment").val().replace(/^.*\\/, ""));
});
$("#proceed-add-client").click(function(e){
	var error = 0;
	if(checkFields() == 1)
	{
		alertify.error("Fields marked red are required.");
		error = 1;
	}
	if(getTargetData() == 1)
	{
		error = 1;
	}

	if(error == 0)
	{
		$("#proceed-add-client").attr('disabled', 'true');
		Pace.restart();
		Pace.track(function(){
			var functions = getTargetData(); //functions information
			var data 	= {
							'team_name' 		  : $("#client-name").val(),
							'division_id'		  : $("#industry").val(),
							'customer_experience' : $("#customer-exp").val(),
							'back_office' 		  : $("#back-office").val(),
							'F_and_a' 			  : $("#fa").val(),
							'hq' 				  : $("#hq").val(),
							'tier' 			      : $("#tier").val(),
							'case_study' 		  : $("#case-study").val(),
							'visit' 			  : $("#visit").val(),
							'target_market'		  : $("#target-market").val(),
							'segment'			  : $("#segment").val(),
							'job_desc' 			  : $("#job-desc").val(),
							'address'			  : $("#client-address").val()
						} // basic information
			var contract= {
							'contract' 		  	  : $("#contract").val(),
							'start_date'	  	  : $("#s_date").val(),
							'expiry_date'		  : $("#e_date").val(),
							'headcount' 		  : $("#headcount").val(),
							'remarks' 			  : $("#remarks").val(),
							'type'				  : 'main',
							'MSA'			  	  : 'main'
						} //contract information
			waitingDialog.show('Processing data...', {dialogSize: 'sm', progressType: 'success'});
			$.post("addClient", {client: data, functions: functions, contract:contract, add: 'true', client_name:$("#client-name").val(), document:$("#attachment").val().replace(/^.*\\/, "")}, function(r){
				if(r != 0)
				{
					document.cookie = "contract_id=" + r + "; path = /";
					if($("#attachment").val() != undefined && $("#attachment").val() != "")
					{
						var data = new FormData();
						$.each($("#attachment")[0].files, function(i, file){
							data.append("sup_doc", file);
						});
						$.ajax({
									url: "uploadDoc",
									type: "POST",
									processData: false,
									data: data,
									contentType: false,
									success:function(res)
									{
										if(res == 1)
										{
											alertify.success("Client was successfully added.");
											setTimeout(function(){
												                	location.reload();
												                }, 1500);
										}
										else
										{
											alertify.success("Client was successfully added.");
											alertify.message("Failed to upload the document. Please reupload the document in the edit module.");
										}
									}
								});
					}	
					else
					{
						alertify.success("Client was successfully added.");
						alertify.message("Supporting document was not provided.");
					}				
				}
				else
				{
					alertify.error("Error adding client. Please try again.");
				}
					waitingDialog.hide();
					setTimeout(function(e){
						location.reload();
					}, 5000);
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
							'tier' 			      : $("#tier").val(),
							'case_study' 		  : $("#case-study").val(),
							'visit' 			  : $("#visit").val(),
							'target_market'		  : $("#target-market").val(),
							'segment'			  : $("#segment").val(),
							'job_desc' 			  : $("#job-desc").val(),
							'address'			  : $("#client-address").val(),
							'ref_no'			  : $("#client-name").data('ref')
						}
			$.post("editClient", {client: data, client_line: client_line, edit: 'true', team_id:team_id, client_name:$("#client-name").val()}, function(r){
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

$(".view-contract").click(function(e){
	var id 			= $(this).data('pk');
	var contract 	= $(this).data('contract');
	var start_date 	= $(this).data('start_date');
	var expiry_date = $(this).data('expiry_date');
	var headcount 	= $(this).data('headcount');
	var remarks 	= $(this).data('remarks');
	var documents 	= $(this).data('document');

	var html = '<section class="content"><div class="row"><div class="form-group col-md-12"><label class="control-label col-sm-1">Contract:</label><div class="col-md-3"><input type="text" class="form-control" id="contract"></div><label class="control-label col-md-1">Headcount:</label><div class="col-md-3"><input readOnly type="number" class="form-control" id="headcount"></div><div class="row"><label class="control-label col-md-1">Document: </label><div class="col-md-3" id="append-doc"></div></div></div><div class="form-group col-md-12"><label class="control-label col-md-1">Start Date:</label><div class="col-md-3"><input type="text" class="form-control date-picker" id="s_date" ></div><label class="control-label col-md-1">End Date:</label><div class="col-md-3"><input type="text" class="form-control date-picker" id="e_date" ></div></div></div><div class="row"><div class="form-group col-md-12"><label class="control-label col-md-1">Remarks: </label><div class="col-md-5"><textarea id="remarks" class="form-control" placeholder="Write something here.."></textarea></div></div></div><hr>';
	html += '<div class="row"><div class="form-group col-md-12"><table class="table"><thead><tr><th class="text-center">Contract</th><th class="text-center">Start Date</th><th class="text-center">Expiry Date</th><th class="text-center">Headcount</th><th class="text-center">Remarks</th><th class="text-center">Attachment</th><th><i class="fa fa-2x fa-plus-circle text-success" style="cursor:pointer;" id="add-annex"></i></th></tr></thead>';
	html += '<tbody><tr><td><input type="text" class="form-control contract" name="contract[]"></td><td><input type="text" name="start_date[]" class="form-control start_date date-picker"></td><td><input type="text" class="form-control expiry_date date-picker" name="expiry_date[]"></td><td><input type="number" class="form-control" readOnly name="headcount[]"></td><td><input type="text" class="form-control remarks" name="remarks[]"></td><td class="attachment-attach"></td><td><i class="fa fa-remove fa-2x text-danger remove-annex pointer"></i></td></tr></tbody></table></div></div></section>';
	BootstrapDialog.show({
        title: 'Manage Contract',
		size: BootstrapDialog.SIZE_WIDE,
        message: html,
        closable: false,
        onshown: function(e)
        {
        	$(".modal-dialog").css('width', '90%');

        	$(".date-picker").datepicker({
                autoclose: true,
                format: 'yyyy-m-dd'
            });

            $("#contract").val(contract);
    		$("#headcount").val(headcount);
    		$("#s_date").val(start_date);
    		$("#e_date").val(expiry_date);
    		$("#remarks").val(remarks);
    		if(documents != "")
    		{
    			$("#append-doc").append(
    									'<a href="'+window.location.hostname+'/ssg/assets/uploads/'+documents+'" download><i class="fa fa-paperclip" ></i>&nbsp; &nbsp;<u>'+documents+'</u></a>'+
    									'&nbsp;&nbsp;&nbsp;<i id="remove-doc" class="fa fa-remove text-danger" title="remove document" style="cursor:pointer;" data-doc="'+documents+'"></i>'
    									);
    		}
    		else
    		{
    			$("#append-doc").append('<input type="file" class="form-control" id="document" >');
    		} //append document

    		$(document).on('click', '#remove-doc', function(e){
    			var file = $(this).data('doc');
    			$.confirm({
						    title: 'Warning!',
						    content: 'Are you sure you want to remove this document?',
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
									    			$.post("../editClient", {id:id, remove_doc:'true', filename:file}, function(r){
									    				if(r == 1)
									    				{
									    					alertify.success("Document was successfully removed.");
									    					setTimeout(function(e){
									    						location.reload();
									    					}, 1500);
									    				}
									    				else
									    				{
									    					alertify.error("Error removing document.");
									    				}
													});
												});
											}
								        }						        
						    		}
				});
    		}); //remove document

    		$(document).on('click', '#add-annex', function(e){
    			var html = '<div class="row"><div class="form-group col-md-12"><table class="table"><thead><tr><th class="text-center">Contract</th><th class="text-center">Start Date</th><th class="text-center">Expiry Date</th><th class="text-center">Headcount</th><th class="text-center">Type</th><th class="text-center">Remarks</th><th class="text-center">Attachment</th></tr></thead>';
				html += '<tbody><tr><td><input type="text" class="form-control" id="contract-new" placeholder="Contract Name"></td><td><input type="text" placeholder="Start Date" class="form-control date-picker" id="start_date_new"></td><td><input type="text" class="form-control  date-picker" placeholder="Expiry Date" id="expiry_date_new"></td><td><input type="number" class="form-control" id="headcount-new" readOnly placeholder="Headcount"></td><td><select class="form-control" id="type"><option value="annex">Annex</option><option value="Document">Document</option></select></td><td><input type="text" class="form-control" id="remarks-new" placeholder="Remarks"></td><td class="text-center"><div class="btn btn-default btn-file"><i class="fa fa-paperclip"></i> <medium id="file-name">Supporting Document</medium><input type="file" name="sup_doc" id="attachment" ></div></td></tr></tbody></table></div></div></section><hr>';
				html += '<div class="row"><div class="form-group col-md-12"><table class="table"><thead><tr><th class="text-center">Current Function</th><th class="text-center">Billed HC</th><th class="text-center">Cost per Title</th><th class="text-center">Ttl Cost</th><th class="text-center">Hours Worked</th><th class="text-center">Timezone</th><th class="text-center">Shift</th><th class="text-center">Location</th><th><i class="fa fa-2x fa-plus-circle text-success" style="cursor:pointer;" id="add-column-target"></i></th></tr></thead>';
				html += '<tbody id="target-data"><tr class="target-clone"><td><select class="form-control functions" id="func-1" data-pk="1" name="functions[]"><option value="">Select Current Function..</option></select></td><td><input type="number" name="billed[]" class="form-control billed"></td><td class="cost-td"><input type="number" class="form-control cost" name="cost[]"></td><td><input type="number" class="form-control ttl-cost" readOnly name="ttl-cost[]"></td><td><input type="text" class="form-control " name="hours[]"></td><td><select class="form-control" name="timezone[]"><option value="">Select timezone..</option><option value="US">US</option><option value="Manila">Manila</option></select></td><td><select class="form-control " name="shift[]"><option value="">Select shift..</option><option value="Night">Night</option><option value="Day">Day</option></select></td><td><select class="form-control" name="location[]"><option value="">Select Location..</option><option value="Makati">Makati</option><option value="Legazpi">Legazpi</option></select></td><td><i class="fa fa-close fa-2x remove-target text-danger" style="cursor:pointer;"></i></td></tr></tbody></table></div></div></section>';
    			BootstrapDialog.show({
			        title: 'Add New Contract',
					size: BootstrapDialog.SIZE_WIDE,
			        message: html,
			        onshown: function()
			        {
			        	$(".modal-dialog").css('width', '90%');
			        	$(".date-picker").datepicker({
			                autoclose: true,
			                format: 'yyyy-m-dd'
			            });

			            $.post("../targetsAndActuals", {joborder_list:"true"}, function(r){
			        		var data = jQuery.parseJSON(r);
			        		var functions = "<option value=''>Select Current Function...</option><option value='add'>Add Function</option>";
			        		$.each(data, function(key, val){
			        			functions += "<option value='"+this.joborder_id+"'>"+this.title+"</option>";
			        		});
			        		functions+="<option value=''>"
			        		$(".functions").html(functions);
			        	}); //get jobs
			        	
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
				        }); //add column function

				       	$(document).on('click', '.remove-target', function(e){
				       		var count = $(this).data('pk');
				        	$("#remove-tr-" + count).remove();
				        	var billed = 0;
							$("input[name^='billed[]'").each(function(e){
								if($(this).val() != "")
								{
									billed += parseFloat($(this).val());
								}
							});
							$("#headcount-new").val(billed);
				        }); //remove function

						$(document).on('keyup', '.billed', function(e){
							var billed = 0;
							var cost = $(this).closest('tr').find('.cost').val();
							$("input[name^='billed[]'").each(function(e){
								if($(this).val() != "")
								{
									billed += parseFloat($(this).val());
								}
							});
							$("#headcount-new").val(billed);
							$(this).closest('tr').find('.ttl-cost').val((parseFloat($(this).val()) * parseFloat(cost)));
				        }); //get total billed count
				        $(document).on('keyup','.cost', function(e){
				        	var billed = $(this).closest('tr').find('.billed').val();
				        	$(this).closest('tr').find('.ttl-cost').val((parseFloat($(this).val()) * parseFloat(billed)));
				        });
			        },
			        buttons: [
			        			{
			        				label: '<i class="fa fa-close"></i>&nbsp;&nbsp;Close',
						            cssClass: 'btn btn-sm btn-default pull-left',
						            action: function(dialog) {
						               dialog.close();
						            }
			        			},
			        			{
			        				label: '<i class="fa fa-plus"></i>&nbsp;&nbsp;Proceed',
						            cssClass: 'btn btn-sm btn-primary pull-right',
						            action: function(dialog) {
						               $
						            }
			        			}
			        		]
			    });
    		});
        
			
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
        				label: '<i class="fa fa-plus"></i>&nbsp;&nbsp;Proceed',
			            cssClass: 'btn btn-sm btn-primary pull-right',
			            action: function(dialog) {
			               
			            }
        			}
        ]

	});
});

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

// $("#table-add-update").click(function(e){
// 	if($(this).data('pk') == 'add-new')
// 		var title = "Add New Client";
// 	else
// 		var title = "Manage Contract";
// 	var html = '<section class="content"><div class="row"><div class="form-group col-md-12"><label class="control-label col-sm-1">Contract:</label><div class="col-md-2"><input type="text" class="form-control" id="contract"></div><label class="control-label col-sm-1">Type:</label><div class="col-md-2"><select class="form-control" id="type"><option value="">Select contract type..</option><option value="main">Main</option><option value="annex">Annex</option></select></div><label class="control-label col-md-1 type-label" hidden>MSA:</label><div class="col-md-2 type-div" hidden><select class="form-control" id="msa"></select></div><label class="control-label col-md-1">Headcount:</label><div class="col-md-2"><input readOnly type="number" class="form-control" id="headcount"></div></div></div><div class="row"><div class="form-group col-md-12"><label class="control-label col-md-1">Start Date:</label><div class="col-md-2"><input type="text" class="form-control date-picker" id="s_date" ></div><label class="control-label col-md-1">End Date:</label><div class="col-md-2"><input type="text" class="form-control date-picker" id="e_date" ></div></div></div><div class="row"><div class="form-group col-md-12"><label class="control-label col-md-1">Remarks: </label><div class="col-md-5"><textarea id="remarks" class="form-control" placeholder="Write something here.."></textarea></div><label class="control-label col-md-1">Document: </label><div class="col-md-3"><input type="file" class="form-control" id="document" ></div></div></div><hr>';
// 	html += '<div class="row"><div class="form-group col-md-12"><table class="table"><thead><tr><th class="text-center">Current Function</th><th class="text-center">Billed HC</th><th class="text-center">Cost per Title</th><th class="text-center">Ttl Cost</th><th class="text-center">Hours Worked</th><th class="text-center">Timezone</th><th class="text-center">Shift</th><th class="text-center">Location</th><th><i class="fa fa-2x fa-plus-circle text-success" style="cursor:pointer;" id="add-column-target"></i></th></tr></thead>';
// 	html += '<tbody id="target-data"><tr class="target-clone"><td><select class="form-control functions" id="func-1" data-pk="1" name="functions[]"><option value="">Select Current Function..</option></select></td><td><input type="number" name="billed[]" class="form-control billed"></td><td class="cost-td"><input type="number" class="form-control cost" name="cost[]"></td><td><input type="number" class="form-control ttl-cost" readOnly name="ttl-cost[]"></td><td><input type="text" class="form-control " name="hours[]"></td><td><select class="form-control" name="timezone[]"><option value="">Select timezone..</option><option value="US">US</option><option value="Manila">Manila</option></select></td><td><select class="form-control " name="shift[]"><option value="">Select shift..</option><option value="Night">Night</option><option value="Day">Day</option></select></td><td><select class="form-control" name="location[]"><option value="">Select Location..</option><option value="Makati">Makati</option><option value="Legazpi">Legazpi</option></select></td><td><i class="fa fa-close fa-2x remove-target text-danger" style="cursor:pointer;"></i></td></tr></tbody></table></div></div></section>';
// 	BootstrapDialog.show({
//         title: title,
// 		size: BootstrapDialog.SIZE_WIDE,
//         message: html,
//         onshown: function(e)
//         {
//         	$(".modal-dialog").css('width', '90%');
//         	$(".date-picker").datepicker({
//                 autoclose: true,
//                 format: 'yyyy-m-dd'
//             });

//         	$(document).on('change','#type', function(e){
//         		var type = $(this).val();
//         		if(type == 'annex')
//         		{
//         			$(".type-div").removeAttr('hidden');
//         			$(".type-label").removeAttr('hidden');
//         		}
//         		else
//         		{
//         			$(".type-div").attr('hidden','true');
//         			$(".type-label").attr('hidden','true');
//         		}
//         	});

//         	$.post("../manageContract",{get_msa:'true'}, function(r){
//         		var data   = jQuery.parseJSON(r);
//         		var option = "<option value=''>Select MSA..</option>";
//         		$.each(data, function(key, val){
//         			option += "<option value='"+this.team_line_id+"' data-start='"+this.start_date+"' data-end='"+this.expiry_date+"'>"+this.contract+"</option>";
//         		});
//         		$("#msa").append(option);
//         	}); //get msa
	        

//         	$.post("../targetsAndActuals", {joborder_list:"true"}, function(r){
//         		var data = jQuery.parseJSON(r);
//         		var functions = "<option value=''>Select Current Function...</option><option value='add'>Add Function</option>";
//         		$.each(data, function(key, val){
//         			functions += "<option value='"+this.joborder_id+"'>"+this.title+"</option>";
//         		});
//         		functions+="<option value=''>"
//         		$(".functions").html(functions);
//         	}); //get jobs
        	
//         	$("#add-column-target").click(function(e){
// 	        	var count = $(".target-clone").length;
// 	        	var clone_target = $(".target-clone:first").clone();
// 	        	clone_target.attr('id', 'remove-tr-'+(count+1));
// 	        	clone_target.find('i').attr('id', 'remove-'+ (count + 1));
// 	        	clone_target.find('.functions').attr('data-pk', (count + 1));
// 	        	clone_target.find('.functions').attr('id', 'func-'+ (count + 1));
// 	        	clone_target.find('i').attr('data-pk', count + 1);
// 	        	$("#target-data").append(clone_target);
// 	        	clearData(clone_target);
// 	        }); //add column function

// 	       	$(document).on('click', '.remove-target', function(e){
// 	       		var count = $(this).data('pk');
// 	        	$("#remove-tr-" + count).remove();
// 	        	var billed = 0;
// 				$("input[name^='billed[]'").each(function(e){
// 					if($(this).val() != "")
// 					{
// 						billed += parseFloat($(this).val());
// 					}
// 				});
// 				$("#headcount").val(billed);
// 	        }); //remove function

// 			$(document).on('change','.functions', function(e){
// 	        	if($(this).val() == "add")
// 	        	{
// 	        		var count_id = $(this).data('pk');
// 	        		BootstrapDialog.show({
// 	        			title: 'Add Function',
// 	        			message: '<center><input type="text" class="form-control" placeholder="Add new function" id="add-function-input"></center>',
// 	        			closable: false,
// 	        			buttons: [
// 	        						{
// 	        							label: '<i class="fa fa-close"></i>&nbsp;&nbsp;Close',
// 								            cssClass: 'btn btn-sm btn-default pull-left',
// 								            action: function(dialog) {
// 								               dialog.close();
// 								               $("#func-"+count_id).val("");
// 								            }
// 	        					 	},
// 	        					 	{
// 	        					 		label: '<i class="fa fa-plus-circle"></i>&nbsp;&nbsp; Add',
// 							            cssClass: 'btn btn-sm btn-primary pull-right',
// 							            id: 'proceed-add-func-btn',
// 							            action: function(dialog) 
// 							            {
// 							            	var new_function = $("#add-function-input").val();
// 								            if(new_function != "")
// 								            {
// 								            	$("#proceed-add-func-btn").attr('disabled', 'true');
// 								            	$.post("targetsAndActuals", {new_function:new_function, add_function:'true'}, function(r){
// 								            		if(r != 0)
// 								            		{
// 								            			$("#func-"+count_id).append("<option selected value='"+r+"'>"+new_function+"</option>");
// 								            			dialog.close();
// 								            		}
// 								            		else
// 								            			alertify.error("Error adding new function.");
// 								            	});
// 							            	}
// 							            	else
// 							            	{
// 							            		alertify.error("Job name cannot be empty.");
// 							            	}
// 							            }
// 	        					 	}
// 	        					 ],
// 	        		});
// 	        	}
// 	        }); // adding new function
// 	        $(document).on('keyup', '.billed', function(e){
// 				var billed = 0;
// 				var cost = $(this).closest('tr').find('.cost').val();
// 				$("input[name^='billed[]']").each(function(e){
// 					if($(this).val() != "")
// 					{
// 						billed += parseFloat($(this).val());
// 					}
// 				});
// 				$("#headcount").val(billed);
// 				$(this).closest('tr').find('.ttl-cost').val((parseFloat($(this).val()) * parseFloat(cost)));
// 	        }); //get total billed count
// 	        $(document).on('keyup','.cost', function(e){
// 	        	var billed = $(this).closest('tr').find('.billed').val();
// 	        	$(this).closest('tr').find('.ttl-cost').val((parseFloat($(this).val()) * parseFloat(billed)));
// 	        });
//         },
//         buttons: [
//         			{
//         				label: '<i class="fa fa-close"></i>&nbsp;&nbsp;Close',
// 			            cssClass: 'btn btn-sm btn-default pull-left',
// 			            action: function(dialog) {
// 			               dialog.close();
// 			               location.reload();
// 			            }
//         			},
//         			{
//         				label: '<i class="fa fa-plus"></i>&nbsp;&nbsp;Proceed',
// 			            cssClass: 'btn btn-sm btn-primary pull-right',
// 			            action: function(dialog) {
			               
// 			            }
//         			}
//         ]

// 	});
// }); //add new contract 

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
}); //add column function

$(document).on('click', '.remove-target', function(e){
	var count = $(this).data('pk');
	$("#remove-tr-" + count).remove();
	var billed = 0;
	$("input[name^='billed[]'").each(function(e){
		if($(this).val() != "")
		{
			billed += parseFloat($(this).val());
		}
	});
	$("#headcount").val(billed);
}); //remove function

$(document).on('keyup', '.billed', function(e){
	var billed = 0;
	var cost = $(this).closest('tr').find('.cost').val();
	$("input[name^='billed[]']").each(function(e){
		if($(this).val() != "")
		{
			billed += parseFloat($(this).val());
		}
	});
	$("#headcount").val(billed);
	$(this).closest('tr').find('.ttl-cost').val((parseFloat($(this).val()) * parseFloat(cost)));
}); //get total billed count
$(document).on('keyup','.cost', function(e){
	var billed = $(this).closest('tr').find('.billed').val();
	$(this).closest('tr').find('.ttl-cost').val((parseFloat($(this).val()) * parseFloat(billed)));
});//get total cost count

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
					            	$.post("./targetsAndActuals", {new_function:new_function, add_function:'true'}, function(r){
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
}); // adding new function
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
			        				var client_name = $("#client").children("option:selected").text();
			        				$.post("targetsAndActuals", {add:'true', client:client, line: data_target, client2:client2, id:$("#client").val(), client_name:client_name}, function(r){
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

	if($("#contract").val() == "" || $("#contract").val() == undefined)
	{
		$("#contract").css('border', '1px solid red');
		error = 1;
	}

	if($("#s_date").val() == "" || $("#s_date").val() == undefined)
	{
		$("#s_date").css('border', '1px solid red');
		error = 1;
	}

	if($("#e_date").val() == "" || $("#e_date").val() == undefined)
	{
		$("#e_date").css('border', '1px solid red');
		error = 1;
	}

	if($("#headcount").val() == "" || $("#headcount").val() == undefined)
	{
		$("#headcount").css('border', '1px solid red');
		error = 1;
	}

	if($("#remarks").val() == "" || $("#remarks").val() == undefined)
	{
		$("#remarks").css('border', '1px solid red');
		error = 1;
	}

	if($("#attachment").val() == "" || $("#attachment").val() == undefined)
	{
		$(".btn-file").css('border', '1px solid red');
		error = 1;
	}
	return error;
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
							'function' 			 : functions[i],
							'billed_hc'			 : billed[i],
							'cost_per_title'     : cost[i],
							'ttl_cost' 			 : ttl_cost[i],
							'hours_work'    	 : hours[i],
							'timezone' 			 : timezone[i],
							'shift'    			 : shift[i],
							'location' 			 : location[i]
						}
					);
		}
		return data;
	}
	return error;
}


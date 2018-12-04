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

$(document).on('keyup change', '.billed', function(e){
	var billed = 0;
	var cost = $(this).closest('tr').find('.cost').val();
	$("input[name^='billed[]'").each(function(e){
		if($(this).val() != "")
		{
			billed += parseFloat($(this).val());
		}
	});
	$("#headcount").val(billed);
	$(this).closest('tr').find('.ttl-cost').val((parseFloat($(this).val()) * parseFloat(cost)));
}); //get total billed count
$(document).on('keyup change','.cost', function(e){
	var billed = $(this).closest('tr').find('.billed').val();
	$(this).closest('tr').find('.ttl-cost').val((parseFloat($(this).val()) * parseFloat(billed)));
});
//--------------------------------------------------- Attach Files ------------------------------------------------------>
$(document).on('click', '.attach-file',function(e){
	var kulit 		= 0;
	var contract_id = $(this).data('contract');
	var client_id   = $(this).data('client');
	var html = '<center><div class="btn btn-default btn-file"><i class="fa fa-paperclip"></i> <medium id="file-name">Add Supporting Documents</medium><input type="file" name="sup_doc[]" id="attachment" multiple></div><hr><div id="append-here"></div>';
	BootstrapDialog.show({
		title: 'Add Documents',
		message: html,
		size: BootstrapDialog.SIZE_NORMAL,
		closable: false,
		type: 'type-info',
		onshown: function()
		{
			getDocuments(contract_id, client_id);
			removeAttachedFile(contract_id, client_id);
			$(document).on('change', '#attachment', function(e){
				var count = 0;
				$.each($("#attachment")[0].files, function(i, file){
					count++;
				});
				$("#file-name").html(count+" attached files");
				$(".attach-me").removeAttr('disabled');
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
						label: '<i class="fa fa-anchor"></i>&nbsp;&nbsp;Attach',
			            cssClass: 'btn btn-sm btn-info pull-right attach-me',
			            action: function(dialog) {
			            	if($("#attachment").val() != "" && $("#attachment").val() != undefined)
				            {
				            	document.cookie = "client_id=" + client_id + "; path = /";
								document.cookie = "contract_id=" + contract_id + "; path = /";
				            	var data = new FormData();
								$.each($("#attachment")[0].files, function(i, file){
									data.append("sup_doc[]", file);
								});
								
								$.ajax({
											url: "../uploadDoc",
											type: "POST",
											processData: false,
											data: data,
											contentType: false,
											success:function(res)
											{
												if(res == 1)
												{
													$(".attach-me").attr('disabled','true');
													alertify.success("<i class='fa fa-check'></i> Document was successfully added.");
													getDocuments(contract_id, client_id);
													$("#file-name").html('<medium id="file-name">Add Supporting Documents</medium>');
												}
												else
												{
													alertify.error("<i class='fa fa-remove'></i>Failed to upload the document.");
												}
											}
										});
							}
							else
							{
								kulit = kulit + 1;
								if(kulit > 5)
								{
									for(var i = 0; i < 20; i++)
									{
										alertify.error("ANG KULIT MO.");
									}
								}
								else
								{
									alertify.error("There are no files attached.");
								}
							}
			            }
					}
		]
	});
});
//--------------------------------------------------- Attach Files ------------------------------------------------------>
$("#attachment").change(function(e){
	var counter = 0;
	$.each($("#attachment")[0].files, function(i, file){
		counter++;
	});
	$("#file-name").html(counter + " files attached.");
});

$("#add-team").click(function(e){
	var count = $(".clone-team").length;
	var clone_target = $(".clone-team:first").clone();
	clone_target.attr('id', 'remove-team-'+(count+1));
	clone_target.find('button').attr('data-pk', count + 1);
	$("#append-team").append(clone_target);
	clearData(clone_target);
}); //add team

$(document).on('click', '.remove-team', function(e){
	var count = $(this).data('pk');
	$("#remove-team-" + count).remove();
}); //remove function

$(".remove-team-edit").click(function(e){
	var id = $(this).data('pk');
	Pace.restart();
	Pace.track(function(e){
		$.confirm({
					title: 'Warning!',
				    content: 'Are you sure you want to remove this team?',
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
							    			$.post("../editClient", {id:id, remove_team:'true'}, function(r){
							    				if(r == 1)
							    				{
							    					alertify.success("<i class='fa fa-check'></i>Team was successfully removed.");
							    				}
							    				else
							    				{
							    					alertify.error("<i class='fa fa-remove'></i>Error removing team.");
							    				}
											});
										});
									}
						        }						        
				    		}
		});
		setTimeout(function(){
			location.reload();
		}, 1500);
	});
});
$("#proceed-add-client").click(function(e){
	var error = 0;
	var team = [];
	if($(".team-name").val() == "" || $(".team-name").val() == undefined)
	{
		$(".team-name").css('border', '1px solid red');
		//error = 1;
	}
	else
	{
		var temp = [];
		$("input[name='team_name[]']").each(function(e){
			temp.push($(this).val());
		});

		for(var i = 0; i < temp.length; i++)
		{
			team.push(
						{
							division_id : $("#industry").val(),
							team_name   : temp[i]
						}
					);
		}
	}

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
							'client_name' 		  : $("#client-name").val(),
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
						} //contract information
			waitingDialog.show('Processing data...', {dialogSize: 'sm', progressType: 'success'});
			$.post("addClient", {client: data, functions: functions, contract:contract, add: 'true', client_name:$("#client-name").val(), team:team}, function(r){
				console.log(r);
				if(r != 0)
				{
					if($("#attachment").val() != undefined && $("#attachment").val() != "")
					{
						var result = jQuery.parseJSON(r);
						document.cookie = "team_id=" + result['team_id'] + "; path = /";
						document.cookie = "contract_id=" + result['contract_id'] + "; path = /";
						var data  = new FormData();
						var counter = 0;
						$.each($("#attachment")[0].files, function(i, file){
							data.append("sup_doc[]", file);
							counter++;
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
											alertify.success("<i class='fa fa-check'></i>Client was successfully added.");
										}
										else
										{
											alertify.success("<i class='fa fa-check'></i>Client was successfully added.");
											alertify.message("Failed to upload the document. Please reupload the document in the edit module.");
										}
									}
								});
					}	
					else
					{
						alertify.success("<i class='fa fa-check'></i>Client was successfully added.");
						alertify.message("Supporting document was not provided.");
					}			
				}
				else
				{
					alertify.error("<i class='fa fa-remove'></i>Error adding client. Please try again.");
				}
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

$("#edit-team").click(function(e){
	waitingDialog.show('Adding team...', {dialogSize: 'sm', progressType: 'success'});
	var client_id = $(this).data('client');
	Pace.restart();
	Pace.track(function(){
		$.post('../editClient', {add_team:'true', client_id:client_id}, function(r){
			if(r == 1)
				setTimeout(function(){
					location.reload();
				}, 1000);
			else
				alertify.error("Error adding team");
		});
	});
	waitingDialog.hide();
});

$("#proceed-delete-client").click(function(e){
	var id = $("#client-name").data('id');
	$.confirm({
			    title: 'Warning!',
			    content: 'Are you sure you want to delete this client?',
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
						    			$.post("../editClient", {id:id, delete_client:'true'}, function(r){
						    				if(r == 1)
						    				{
						    					alertify.success("<i class='fa fa-check'></i>Client was successfully deleted.");
						    					setTimeout(function(){
						    						window.location = "../client";
						    					}, 1500);
						    				}
						    				else
						    				{
						    					alertify.error("<i class='fa fa-remove'></i>Error removing client.");
						    				}
										});
									});
								}
					        }						        
			    		}
	});
});

$("#proceed-update-client").click(function(e){
	var error = 0;
	var team = [];
	var temp = [];
	$("input[name='team_name[]']").each(function(e){
		if($(this).val() == "" || $(this).val() == undefined)
		{
			$(this).css('border', '1px solid red');
			//error = 1;
		}
		else
		{
			temp.push(
						{
							team_id     : $(this).data('pk'),
							team_name   : $(this).val()
						}
					);
		}
	});
	for(var i = 0; i < temp.length; i++)
	{
		team.push(
					{
						division_id : $("#industry").val(),
						team_name   : temp[i]['team_name'],
						team_id		: temp[i]['team_id']
					}
				);
	}
	
	if(checkBasicInfo() == 1)
	{
		alertify.error("Fields marked red are required.");
		error = 1;
	}
	if(error == 0)
	{
		Pace.restart();
		Pace.track(function(){
			waitingDialog.show('Processing data...', {dialogSize: 'sm', progressType: 'success'});
			var team_id 	= $("#client-name").data('id');
			var data = {
							'client_name' 		  : $("#client-name").val(),
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
			$.post("editClient", {client: data, edit: 'true', client_id:team_id, client_name:$("#client-name").val(), team:team}, function(r){
				if(r == 1)
					alertify.success("<i class='fa fa-check'></i>   Client was successfully updated.");
				else
					alertify.error("<i class='fa fa-remove'></i>   Error updating client. Please try again.");
				waitingDialog.hide();
				setTimeout(function(e){
					location.reload();
				}, 1500);
			});
		});
	}
	else
	{
		alertify.error("All fields are required.");
	}
}); //edit client info 
//---------------------------------------------- ALL IN MODAL (Manage Contract) ------------------------------------------->
$(".view-contract").click(function(e){
	waitingDialog.show('Fetching data...', {dialogSize: 'sm', progressType: 'success'});
	var id 			= $(this).data('pk');
	var contract 	= $(this).data('contract');
	var start_date 	= $(this).data('start_date');
	var expiry_date = $(this).data('expiry_date');
	var headcount 	= $(this).data('headcount');
	var remarks 	= $(this).data('remarks');
	var documents 	= $(this).data('document');
	var client_id 	= $(this).data('client-id');

	var html = '<section class="content" style="overflow:auto;"><div  style="width:99%;"><div class="row"><div class="form-group col-md-12"><label class="control-label col-sm-1">Contract:</label><div class="col-md-3"><input type="text" class="form-control" id="contract"></div><label class="control-label col-md-1">Headcount:</label><div class="col-md-3"><input readOnly type="number" class="form-control" id="headcount-view"></div><label class="control-label col-md-1">Total HC:</label><div class="col-md-3"><input readOnly type="number" class="form-control" id="total-hc"></div></div><div class="form-group col-md-12"><label class="control-label col-md-1">Start Date:</label><div class="col-md-3"><input type="text" class="form-control date-picker" id="s_date" ></div><label class="control-label col-md-1">End Date:</label><div class="col-md-3"><input type="text" class="form-control date-picker" id="e_date" ></div><label class="control-label col-md-1">Document: </label><div class="col-md-3" id="append-doc"></div></div></div><div class="row"><div class="form-group col-md-12"><label class="control-label col-md-1">Remarks: </label><div class="col-md-3"><textarea id="remarks" class="form-control" placeholder="Write something here.."></textarea></div></div></div><hr>';
	html += '<div class="row"><div class="form-group col-md-12"><table class="table"><thead><tr><th class="text-center">Contract</th><th class="text-center">Start Date</th><th class="text-center">Expiry Date</th><th>Remaining Months</th><th  class="text-center">Type</th><th class="text-center">Headcount</th><th class="text-center">Remarks</th><th class="text-center">Attachment</th><th class="text-center"><button class="btn btn-sm btn-success" style="cursor:pointer;"  id="add-annex"><i class="fa fa-plus">&nbsp;&nbsp;Add annex</button></i></th></tr></thead>';
	html += '<tbody id="append-tbody"></tbody></table></div></div></div></section>';
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
    		$("#s_date").val(start_date);
    		$("#e_date").val(expiry_date);
    		$("#remarks").val(remarks);
    		$("#headcount-view").val(headcount);
    		$("#add-annex").attr('data-s_date', start_date);
    		$("#add-annex").attr('data-e_date', expiry_date);
    		$("#add-annex").attr('data-client-id', client_id);
    		$("#add-annex").attr('data-pk', id);
    		if(documents != 0)
    		{
    			$("#append-doc").append("<button data-contract='"+id+"' data-client='"+client_id+"' class='btn btn-sm btn-info attach-file'><i class='fa fa-paperclip'></i>&nbsp; &nbsp;"+documents+" attached documents</button>");
    		}
    		else
    		{
    			$("#append-doc").append(
    									"<button  data-contract='"+id+"' data-client='"+client_id+"' class='btn btn-sm btn-warning attach-file'><i class='fa fa-paperclip'></i>&nbsp; &nbsp;Attachment is not available</button></div>"
    									);
    		} //append document     

    		$(document).on('change', '.expiry_date', function(e){
    			var expiry_date = $(this).val();
    			var id 			= $(this).data('id');
    			var remaining = getRemainingMonths(expiry_date);
    			$("#"+id).html(remaining);
    		});
    		$.post("../editClient", {contract_list:'true', id:id}, function(r){
    			var data   		= jQuery.parseJSON(r);
    			var append 		= "";
    			var total_hc = headcount;
    			$.each(data, function(key, val){
    				total_hc += parseInt(this.headcount);
    				var remaining = getRemainingMonths(this.expiry_date);

    				append += '<tr><td><input type="text" class="form-control contract" name="contract[]" data-pk="'+this.contract_line_id+'" value="'+this.contract+'"></td><td><input type="text" name="start_date[]" class="form-control start_date date-picker"  value="'+this.start_date+'"></td><td><input type="text" class="form-control expiry_date date-picker" name="expiry_date[]"  value="'+this.expiry_date+'" data-id="'+this.contract_line_id+'"></td><td  class="text-center" id="'+this.contract_line_id+'">'+remaining+'</td><td>';
    				if(this.type=="annex")
    				{
    					append +='<select class="form-control type" name="type[]"><option value="annex" selected>annex</option><option value="document">Document</option></select></td>';
    				}
    				else
    				{
    					append +='<select class="form-control type" name="type[]"><option value="annex">annex</option><option value="document" selected>Document</option></select></td>';
    				}
    				append += '<td><input type="number" class="form-control" readOnly name="headcount[]" value="'+this.headcount+'"></td><td><input type="text" class="form-control remarks" name="remarks[]" value="'+this.remarks+'"></td>';
    				if(this.document == "" || this.document == null || this.document <= 0)
    				{
    					append +='<td class="text-center" id="'+this.contract_line_id+'"><button class="btn btn-sm btn-warning attach-files-child" data-contract="'+this.contract_line_id+'" data-client="'+client_id+'" data-filename="'+this.filename+'">Attach documents</button></td>';
    				}
    				else
    				{
    					append +='<td class="text-center"  id="'+this.contract_line_id+'"><button class="btn btn-sm btn-info attach-files-child" data-contract="'+this.contract_line_id+'" data-client="'+client_id+'" data-count="'+this.document+'"><i class="fa fa-paperclip"></i>&nbsp;&nbsp; '+this.document+'&nbsp; attached documents</button></td>';
    				}
    				append += '<td></td></tr>';
    			});
    			$("#append-tbody").html(append);
    			$(".date-picker").datepicker({
	                autoclose: true,
	                format: 'yyyy-m-dd'
	            });
    			$("#total-hc").val(total_hc);
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
        				label: '<i class="fa fa-plus"></i>&nbsp;&nbsp;Save Changes',
			            cssClass: 'btn btn-sm btn-primary pull-right',
			            action: function(dialog) {
			               	if(checkManageContract() == 1)
			               		alertify.error("All fields are required");
			               	else
			               	{
			               		var contract = {
			               					contract	: $("#contract").val(),
			               					start_date  : $("#s_date").val(),
			               					expiry_date : $("#e_date").val(),
			               					remarks 	: $("#remarks").val()
			               		}
			               		Pace.restart();
			               		Pace.track(function(){
			               			$.post("../editClient", {child:checkManageContract(), mother: contract, id:id, update_contract:'true'}, function(r){
			               				if(r == 1)
			               				{
			               					alertify.success("<i class='fa fa-check'></i>  Contract was successfully updated.");
			               				}
			               				else
			               				{
			               					alertify.error("<i class='fa fa-remove'></i>   An error has occured.");
			               				}
			               				setTimeout(function(){
			               					location.reload();
			               				},1500);
			               			});
			               		});
			               	}
			            }
        			}
        ]

	});
	waitingDialog.hide();
});

$(document).on('click', '.attach-files-child', function(e){
	var contract_id = $(this).data('contract');
	var client_id     = $(this).data('client');
	var count_doc   = parseFloat($(this).data('count'));
	var count 		= 0;
	var html = '<center><div class="btn btn-default btn-file"><i class="fa fa-paperclip"></i> <medium id="file-name">Add Supporting Documents</medium><input type="file" name="sup_doc_new[]" id="attachment" multiple></div><hr><div id="append-here-child"></div>';
	BootstrapDialog.show({
		title: 'Add Documents',
		message: html,
		size: BootstrapDialog.SIZE_NORMAL,
		closable: false,
		type: 'type-info',
		onshown: function()
		{
			getDocumentsChild(contract_id, client_id);
			$(document).on('click', '.remove-file-child', function(e){
				var counter  = returnCount() - 1;
				var id 		 = $(this).data('contract');
				var filename = $(this).data('filename');
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
									    			$.post("../editClient", {id:id, remove_doc2:'true', filename:filename, remove2:'true', count_doc:counter, line_id:contract_id}, function(r){
									    				if(r == 1)
									    				{
									    					alertify.success("<i class='fa fa-check'></i>   Document was successfully removed.");
									    					getDocumentsChild(contract_id, client_id);
									    				}
									    				else
									    				{
									    					alertify.error("<i class='fa fa-remove'></i>   Error removing document.");
									    				}
														// console.log(r);
													});
												});
											}
								        }						        
						    		}
				});
			}); //removes file

			$(document).on('change', '#attachment', function(e){
				count = 0;
				$.each($("#attachment")[0].files, function(i, file){
					count++;
				});
				$("#file-name").html(count+" attached files");
				$(".attach-me").removeAttr('disabled');
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
						label: '<i class="fa fa-anchor"></i>&nbsp;&nbsp;Attach',
			            cssClass: 'btn btn-sm btn-info pull-right attach-me',
			            action: function(dialog) {
			            	$(".attach-me").attr('disabled','true');
			            	var count_doc  = returnCount() + count;
			            	document.cookie = "client_id=" + client_id + "; path = /";
							document.cookie = "contract_id=" + contract_id + "; path = /";
							document.cookie = "counter=" + count_doc + "; path = /";
			            	var data = new FormData();
							$.each($("#attachment")[0].files, function(i, file){
								data.append("sup_doc_new[]", file);
							});
							
							$.ajax({
										url: "../uploadDoc",
										type: "POST",
										processData: false,
										data: data,
										contentType: false,
										success:function(res)
										{
											if(res == 1)
											{
												alertify.success("<i class='fa fa-check'></i>Document was successfully added.");
												getDocumentsChild(contract_id, client_id);
												$("#file-name").html('<medium id="file-name">Add Supporting Documents</medium>');
											}
											else
											{
												alertify.error("<i class='fa fa-remove'></i>Failed to upload the document. Please reupload the document in the edit module.");
											}
										}
									});
			            }
					}
		]
	});
}); //attach files annex 
//---------------------------------------------- ALL IN MODAL (Manage Contract) ----------------------------------------------------->

//--------------------------------------------------- CHILD MODAL (Add new child Contract) ------------------------------------------>
$(document).on('click', '#add-annex', function(e){
	var start_date  = $(this).data('s_date');
	var expiry_date = $(this).data('e_date');
	var id 			= $(this).data('pk');
	var client_id	= $(this).data('client-id');
	var counter 	= 0;

	var html = '<div class="row"><div class="form-group col-md-12"><table class="table"><thead><tr><th class="text-center">Contract</th><th class="text-center">Start Date</th><th class="text-center">Expiry Date</th><th class="text-center">Headcount</th><th class="text-center">Type</th><th class="text-center">Remarks</th><th class="text-center">Attachment</th><th class="text-center">Action</th></tr></thead>';
	html += '<tbody><tr><td><input type="text" class="form-control" id="contract-new" placeholder="Contract Name"></td><td><input type="text" placeholder="Start Date" class="form-control date-picker" id="start_date_new"></td><td><input type="text" class="form-control  date-picker" placeholder="Expiry Date" id="expiry_date_new"></td><td><input type="number" class="form-control" id="headcount-new" readOnly placeholder="Headcount"></td><td><select class="form-control" id="type"><option value="annex">Annex</option><option value="Document">Document</option></select></td><td><input type="text" class="form-control" id="remarks-new" placeholder="Remarks"></td><td class="text-center"><div class="btn btn-default btn-file"><i class="fa fa-paperclip"></i> <medium id="file-name-new">Supporting Document</medium><input type="file" name="sup_doc_new[]" id="attachment-new" multiple></div></td><td>Add:&nbsp;&nbsp;<input value="add" type="radio" name="action" class="action">&nbsp;&nbsp;Deduct: &nbsp;&nbsp;<input type="radio" name="action" class="action" value="deduct"></td></tr></tbody></table></div></div></section><hr>';
	html += '<div class="row"><div class="form-group col-md-12"><table class="table"><thead><tr><th class="text-center">Current Function</th><th class="text-center">Billed HC</th><th class="text-center">Cost per Title</th><th class="text-center">Ttl Cost</th><th class="text-center">Working Hours</th><th class="text-center">Timezone</th><th class="text-center">Shift</th><th class="text-center">Location</th><th><button class="btn btn-sm btn-success" style="cursor:pointer;" id="add-column-target"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add HC</button></th></tr></thead>';
	html += '<tbody id="target-data"><tr class="target-clone"><td><select class="form-control functions" id="func-1" data-pk="1" name="functions[]"><option value="">Select Current Function..</option></select></td><td><input type="number" name="billed[]" class="form-control billed"></td><td class="cost-td"><input type="number" class="form-control cost" name="cost[]"></td><td><input type="number" class="form-control ttl-cost" readOnly name="ttl-cost[]"></td><td><input type="text" class="form-control " name="hours[]"></td><td><select class="form-control" name="timezone[]"><option value="">Select timezone..</option><option value="US">US</option><option value="Manila">Manila</option></select></td><td><select class="form-control " name="shift[]"><option value="">Select shift..</option><option value="Night">Night</option><option value="Day">Day</option><option value="Mid">Mid</option><option value="Graveyard">Graveyard</option></select></td><td><select class="form-control" name="location[]"><option value="">Select Location..</option><option value="Makati">Makati</option><option value="Legazpi">Legazpi</option></select></td><td><i class="fa fa-close fa-2x remove-target text-danger" style="cursor:pointer;"></i></td></tr></tbody></table></div></div></section>';
	BootstrapDialog.show({
        title: 'Add New Contract',
		size: BootstrapDialog.SIZE_WIDE,
        message: html,
        type: 'type-info',
        onshown: function()
        {
        	$(".modal-dialog").css('width', '90%');
        	$(".date-picker").datepicker({
                autoclose: true,
                format: 'yyyy-m-dd'
            });

        	$("#start_date_new").val(start_date);
        	$("#expiry_date_new").val(expiry_date);

        	addRemoveColumn('child');
            functionList();
			$(document).on('keyup change', '.billed', function(e){
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
	        $(document).on('keyup change','.cost', function(e){
	        	var billed = $(this).closest('tr').find('.billed').val();
	        	$(this).closest('tr').find('.ttl-cost').val((parseFloat($(this).val()) * parseFloat(billed)));
	        });

	        $("#attachment-new").change(function(e){
				$.each($("#attachment-new")[0].files, function(i, file){
					counter++;
				});
				$("#file-name-new").html(counter + " files attached.");
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
			            cssClass: 'btn btn-sm btn-info pull-right new-contract-btn',
			            action: function(dialog) {
			            	var error = 0;
			               	if(getTargetData() == 1)
							{
								error = 1;
							}

							if(checkContractInfo() == 1)
							{
								error = 1;
							}

							if($('.action').is(':checked'))
			            	{}
			            	else
			            	{
			            		error = 1;
			            		alertify.error("Action is not identified");
			            	}
							if(error != 1)
							{
								$(".new-contract-btn").attr('disabled','true');
								var headcount = $("#headcount-new").val();
								var action 	  = $("input[name='action']:checked").val();
								if($("input[name='action']:checked").val() == 'deduct')
									headcount = '-'+headcount;
								var contract 	= {
													'contract' 		  	  : $("#contract-new").val(),
													'start_date'	  	  : $("#start_date_new").val(),
													'expiry_date'		  : $("#expiry_date_new").val(),
													'headcount' 		  : headcount,
													'remarks' 			  : $("#remarks-new").val(),
													'type'				  : $("#type").val(),
													'MSA'			  	  : id,
													'client_id'			  : client_id,
													'document'			  : counter
												} //contract information
								$.post("../editClient", {contract:contract, functions: getTargetData(), new_contract: 'true', client_id: client_id, action:action}, function(r){
									if(r != 0)
									{
										if($("#attachment-new").val() != "")
										{
											var result = jQuery.parseJSON(r);
											document.cookie = "client_id=" + result['client_id'] + "; path = /";
											document.cookie = "contract_id=" + result['contract_id'] + "; path = /";
											var data = new FormData();
											$.each($("#attachment-new")[0].files, function(i, file){
												data.append("sup_doc_new[]", file);
											});
											$.ajax({
														url: "../uploadDoc",
														type: "POST",
														processData: false,
														data: data,
														contentType: false,
														success:function(res)
														{
															if(res != 0)
															{
																alertify.success("<i class='fa fa-check'></i>Contract was successfully added.");
																dialog.close();
															}
															else
															{
																alertify.success("<i class='fa fa-check'></i>Contract was successfully added.");
																alertify.message("Failed to upload the document. Please reupload the document in the edit module.");
																dialog.close();
															}
														}
													});
										}	
										else
										{
											alertify.success("<i class='fa fa-check'></i>Contract has been successfully added.");
											dialog.close();
										}
									}
									else
									{
										$(".new-contract-btn").removeAttr('disabled');
										alertify.error("<i class='fa fa-remove'></i>An error has occured");
									}
									setTimeout(function(){
										location.reload();
									}, 1500);
								});
							}
			            }
        			}
        		]
    });
}); //adding child contract

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
				            	var url = window.location.href;
				            	var url = url.split('/');
				            	var new_function = $("#add-function-input").val();
					            if(new_function != "")
					            {
					            	var link = '../targetsAndActuals';
					            	if(url[5] == 'addClient')
					            		var link = 'targetsAndActuals';
					            	$("#proceed-add-func-btn").attr('disabled', 'true');
					            	$.post(link, {new_function:new_function, add_function:'true'}, function(r){
					            		if(r != 0)
					            		{
					            			$("#func-"+count_id).append("<option selected value='"+r+"'>"+new_function+"</option>");
					            			alertify.success("<i class='fa fa-check'></i>Function has been added.");
					            			dialog.close();
					            		}
					            		else
					            			alertify.error("<i class='fa fa-remove'></i>Error adding new function.");
					            	});
				            	}
				            	else
				            	{
				            		alertify.error("<i class='fa fa-remove'></i>Job name cannot be empty.");
				            	}
				            }
					 	}
					 ],
		});
	}
}); // adding new function

//--------------------------------------------------- CHILD MODAL (Add new child Contract) ------------------------------>
//--------------------------------------------------- Primary window (Update Client info) ------------------------------->
$("#add-master-contract").click(function(e){
	var id   = $(this).data('pk');
	var html = '<section class="content" style="overflow:auto;"><div  style="width:99%;"><div class="row" style="overflow:auto;"><div class="form-group col-md-12"><label class="control-label col-sm-1">Contract:</label><div class="col-md-3"><input placeholder="Contract Name" type="text" class="form-control" id="contract"></div><label class="control-label col-md-1">Headcount:</label><div class="col-md-3"><input readOnly type="number" class="form-control" id="headcount" placeholder="Headcount"></div><div class="row"><label class="control-label col-md-1">Document: </label><div class="col-md-3"><div class="btn btn-default btn-file"><i class="fa fa-paperclip"></i> <medium id="file-name">Add Supporting Documents</medium><input type="file" name="sup_doc[]" id="document" multiple></div></div></div></div><div class="form-group col-md-12"><label class="control-label col-md-1">Start Date:</label><div class="col-md-3"><input type="text" placeholder="Start Date" class="form-control date-picker" id="s_date" ></div><label class="control-label col-md-1">End Date:</label><div class="col-md-3"><input type="text" placeholder="Expiry Date" class="form-control date-picker" id="e_date" ></div></div></div><div class="row"><div class="form-group col-md-12"><label class="control-label col-md-1">Remarks: </label><div class="col-md-3"><textarea id="remarks" class="form-control" placeholder="Write something here.."></textarea></div></div></div><hr>';
	html += '<div class="row"><div class="form-group col-md-12"><table class="table"><thead><tr><th class="text-center">Current Function</th><th class="text-center">Billed HC</th><th class="text-center">Cost per Title</th><th class="text-center">Ttl Cost</th><th class="text-center">Working Hours</th><th class="text-center">Timezone</th><th class="text-center">Shift</th><th class="text-center">Location</th><th><button class="btn btn-sm btn-success" style="cursor:pointer;" id="add-column-target"><i class="fa fa-plus" ></i>&nbsp;&nbsp;Add HC</button></th></tr></thead>';
	html += '<tbody id="target-data"><tr class="target-clone"><td><select class="form-control functions" id="func-1" data-pk="1" name="functions[]"><option value="">Select Current Function..</option></select></td><td><input type="number" name="billed[]" class="form-control billed"></td><td class="cost-td"><input type="number" class="form-control cost" name="cost[]"></td><td><input type="number" class="form-control ttl-cost" readOnly name="ttl-cost[]"></td><td><input type="text" class="form-control " name="hours[]"></td><td><select class="form-control" name="timezone[]"><option value="">Select timezone..</option><option value="US">US</option><option value="Manila">Manila</option></select></td><td><select class="form-control " name="shift[]"><option value="">Select shift..</option><option value="Night">Night</option><option value="Day">Day</option><option value="Mid">Mid</option><option value="Graveyard">Graveyard</option></select></td><td><select class="form-control" name="location[]"><option value="">Select Location..</option><option value="Makati">Makati</option><option value="Legazpi">Legazpi</option></select></td><td><i class="fa fa-close fa-2x remove-target text-danger" style="cursor:pointer;"></i></td></tr></tbody></table></div></div></div></section>';
	BootstrapDialog.show({
        title: 'Add New MSA',
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
            addRemoveColumn('master');
            functionList();
            $("#document").change(function(e){
				var counter = 0;
				$.each($("#document")[0].files, function(i, file){
					counter++;
				});
				$("#file-name").html(counter + " files attached.");
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
			            cssClass: 'btn btn-sm btn-primary pull-right new-msa',
			            action: function(dialog) {
			            	var error = 0;
			            	if($("#contract").val() == "")
			            	{
			            		$("#contract").css('border', '1px solid red');
								error = 1;
			            	}
			            	if($("#s_date").val() == "")
			            	{
			            		$("#s_date").css('border', '1px solid red');
								error = 1;
			            	}
							if($("#e_date").val() == "")
			            	{
			            		$("#e_date").css('border', '1px solid red');
								error = 1;
			            	}
			            	if($("#remarks").val() == "")
			            	{
			            		$("#remarks").css('border', '1px solid red');
								error = 1;
			            	}
							if(getTargetData() == 1)
								error = 1;
			            	
			            	if(error != 1)
			            	{
			            		$(".new-msa").attr('disabled','true');
			            		var contract = {
			               					contract	: $("#contract").val(),
			               					start_date  : $("#s_date").val(),
			               					expiry_date : $("#e_date").val(),
			               					remarks 	: $("#remarks").val(),
			               					client_id 	: id,
			               					headcount 	: $("#headcount").val()
			               		}
			               		$.post("../editClient", {contract: contract, function:getTargetData(), add_msa: 'true', id:id}, function(r){
			               			if(r != 0)
			               			{
				               			if($("#document").val() != "")
				               			{
				               				var result = jQuery.parseJSON(r);
											document.cookie = "client_id=" + result['client_id'] + "; path = /";
											document.cookie = "contract_id=" + result['contract_id'] + "; path = /";
											var data = new FormData();
											$.each($("#document")[0].files, function(i, file){
												data.append("sup_doc[]", file);
											});
											$.ajax({
														url: "../uploadDoc",
														type: "POST",
														processData: false,
														data: data,
														contentType: false,
														success:function(res)
														{
															if(res == 1)
															{
																alertify.success("<i class='fa fa-check'></i>Contract was successfully added.");
																setTimeout(function(){
																	                	location.reload();
																	                }, 1500);
															}
															else
															{
																alertify.success("<i class='fa fa-check'></i>Contract was successfully added.");
																alertify.message("Failed to upload the document. Please reupload the document in the edit module.");
															}
														}
													});
										}
										else
										{
											alertify.success("<i class='fa fa-check'></i>Contract was successfully added.");
											setTimeout(function(){
												                	location.reload();
												                }, 1500);
										}
			               			}
			               			else
			               			{
			               				$(".new-msa").removeAttr('disabled');
			               				alertify.error("<i class='fa fa-remove'></i> Error in adding contract");
			               			}
			               		});
			            	}
			            }
			        }
        ]
    });
});

//--------------------------------------------------- View headcount ---------------------------------------------------->
$("#view-headcount").click(function(e){
	var id 	 = $(this).data('pk');
	var name = $(this).data('name');
	var html = '<section class="content" style="overflow:auto;"><div  style="width:99%;"><div class="row"><h4 style="font-family: Century Gothic; font-size:20px; color: #272727; font-weight: light; text-align:center;">'+name+'</h4><br><table class="table table-bordered"><thead><tr style="background-color: #d7d7d8;" ><th class="text-center">Current Function</th><th class="text-center">Billed HC</th><th class="text-center">Cost per Title</th><th>TTL Cost</th><th class="text-center">Working Hours</th><th class="text-center">Timezone</th><th class="text-center">Shift</th><th class="text-center">Location</th></tr></thead><tbody id="append-body"></tbody></table></div></div></section>';
		BootstrapDialog.show({
			title: 'Headcount Detailed List',
			message: html,
			closable: false,
			size: BootstrapDialog.SIZE_WIDE,
			onshown: function()
			{
				$(".modal-dialog").css('width', '90%');
				waitingDialog.show('Fetching data...', {dialogSize: 'sm', progressType: 'success'});
				Pace.restart();
				Pace.track(function(){
					$.post("../getDetailedHeadCount", {id:id}, function(r){
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
				               location.reload();
				            }
						}
					]

		});
});
//--------------------------------------------------- View headcount ---------------------------------------------------->
//--------------------------------------------------- Primary window (Update Client info) ------------------------------->

//----------------------------------------------------END OF UPDATE CLIENT----------------------------------------------->


//------- FUNCTION DEFINITION AREA ------------//

function clearData(clone)
{
	clone.find('input').val('');
  	clone.find('select').val('');
  	clone.find('textarea').val('');
}

function checkFields() //check for client basic info and contract info
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

	// if($("#segment").val() == "" || $("#segment").val() == undefined)
	// {
	// 	$("#segment").css('border', '1px solid red');
	// 	error = 1;
	// }

	// if($("#job-desc").val() == "" || $("#job-desc").val() == undefined)
	// {
	// 	$("#job-desc").css('border', '1px solid red');
	// 	error = 1;
	// }
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

	// if($("#remarks").val() == "" || $("#remarks").val() == undefined)
	// {
	// 	$("#remarks").css('border', '1px solid red');
	// 	error = 1;
	// }

	// if($("#attachment").val() == "" || $("#attachment").val() == undefined)
	// {
	// 	$(".btn-file").css('border', '1px solid red');
	// 	error = 1;
	// }
	return error;
}

function checkContractInfo()
{
	var error = 0;
	if($("#contract-new").val() == "" || $("#contract-new").val() == undefined)
	{
		$("#contract-new").css('border', '1px solid red');
		error = 1;
	}

	if($("#start_date_new").val() == "" || $("#start_date_new").val() == undefined)
	{
		$("#start_date_new").css('border', '1px solid red');
		error = 1;
	}

	if($("#expiry_date_new").val() == "" || $("#expiry_date_new").val() == undefined)
	{
		$("#expiry_date_new").css('border', '1px solid red');
		error = 1;
	}

	if($("#headcount-new").val() == "" || $("#headcount-new").val() == undefined)
	{
		$("#headcount-new").css('border', '1px solid red');
		error = 1;
	}

	if($("#attachment-new").val() == "" || $("#attachment-new").val() == undefined)
	{
		$(".btn-file").css('border', '1px solid red');
		error = 1;
	}

	return error;
}

function getTargetData() //get data for functions
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

function checkManageContract()
{
	var error 		= 0;
	var id 			= [];
	var contract  	= [];
	var start_date 	= [];
	var expiry_date = [];
	var type 		= [];
	var remarks 	= [];
	var data 		= [];
	if($("#contract").val() == "")
		error = 1;
	if($("#s_date").val() == "")
		error = 1;
	if($("#e_date").val() == "")
		error = 1;
	if($("#remarks").val() == "")
		error = 1;

	$("input[name^='contract[]'").each(function(e){
		if($(this).val() == "")
		{
			$(this).css('border', '1px solid red');
			error = 1;
		}
		else
		{
			id.push($(this).data('pk'));
			contract.push($(this).val());
		}
	});
	$("input[name^='start_date[]'").each(function(e){
		if($(this).val() == "")
		{
			$(this).css('border', '1px solid red');
			error = 1;
		}
		else
			start_date.push($(this).val());
	});
	$("input[name^='expiry_date[]'").each(function(e){
		if($(this).val() == "")
		{
			$(this).css('border', '1px solid red');
			error = 1;
		}
		else
			expiry_date.push($(this).val());
	});
	$("select[name^='type[]'").each(function(e){
		if($(this).val() == "")
		{
			$(this).css('border', '1px solid red');
			error = 1;
		}
		else
			type.push($(this).val());
	});
	$("input[name^='remarks[]'").each(function(e){
		if($(this).val() == "")
		{
			$(this).css('border', '1px solid red');
			error = 1;
		}
		else
			remarks.push($(this).val());
	});
	if(error != 1)
	{
		for(var i = 0; i < contract.length; i++)
		{
			data.push(
						{
							'contract' 			 : contract[i],
							'start_date'		 : start_date[i],
							'expiry_date'     	 : expiry_date[i],
							'remarks' 			 : remarks[i],
							'type'    	 		 : type[i],
							'contract_line_id'	 : id[i]
						}
					);
		}
		return data;
	}
	else
	{
		return error;
	}
}

function addRemoveColumn(type)
{
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
		if(type == 'child')
			$("#headcount-new").val(billed);
		else
			$("#headcount").val(billed);
    }); //remove function
}

function functionList()
{
	$.post("../targetsAndActuals", {joborder_list:"true"}, function(r){
		var data = jQuery.parseJSON(r);
		var functions = "<option value=''>Select Current Function...</option><option value='add'>Add Function</option>";
		$.each(data, function(key, val){
			functions += "<option value='"+this.joborder_id+"'>"+this.title+"</option>";
		});
		functions+="<option value=''>"
		$(".functions").html(functions);
	}); //get jobs
}

function checkBasicInfo()
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
	return error;
}

function getDocuments(contract_id, client_id)
{
	$.post("../editClient", {contract_id:contract_id, client_id:client_id, get_files:'true'}, function(r){
		var data  = jQuery.parseJSON(r);
		var attach= "";
		$.each(data, function(key, val){
			attach += "<p><a  class='pull-left' href='../../assets/uploads_msa/"+this.filename+"' download><i class='fa fa-paperclip'></i>&nbsp; &nbsp;<u>"+this.filename+"</u></a>&nbsp;&nbsp;&nbsp;<i class='pull-right pointer fa-2x fa fa-remove text-danger remove-file' data-contract='"+this.file_no+"' data-filename='"+this.filename+"' title='remove file'></i></p><hr>";
		});
		$("#append-here").html(attach);
	});
}

function getDocumentsChild(contract_id, client_id)
{
	$.post("../editClient", {contract_id:contract_id, client_id:client_id, get_files_child:'true'}, function(r){
		var data  = jQuery.parseJSON(r);
		var attach= "";
		var counter = 0;
		$.each(data, function(key, val){
			attach += "<p><a  class='pull-left' href='../../assets/uploads_child/"+this.filename+"' download><i class='fa fa-paperclip'></i>&nbsp; &nbsp;<u>"+this.filename+"</u></a>&nbsp;&nbsp;&nbsp;<i class='pull-right pointer fa-2x fa fa-remove text-danger remove-file-child' data-contract='"+this.file_no+"' data-filename='"+this.filename+"' title='remove file'></i></p><hr>";
			counter++;
		});
		
		$("#append-here-child").html(attach);
		pakshitcounter = counter;
	});
}
var pakshitcounter = 0;
function returnCount()
{
	return pakshitcounter;
}

function removeAttachedFile(contract_id, client_id)
{
	$(document).on('click', '.remove-file', function(e){
		var id 		 = $(this).data('contract');
		var filename = $(this).data('filename');
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
							    			$.post("../editClient", {id:id, remove_doc:'true', filename:filename}, function(r){
							    				if(r == 1)
							    				{
							    					alertify.success("<i class='fa fa-check'></i>Document was successfully removed.");
							    					getDocuments(contract_id, client_id);
							    				}
							    				else
							    				{
							    					alertify.error("<i class='fa fa-remove'></i>Error removing document.");
							    				}
											});
										});
									}
						        }						        
				    		}
		});
	}); //removes file
}

function getRemainingMonths(expiry_date)
{
	var date1  = new Date(expiry_date);
	var year1  = date1.getYear();
	var month1 = date1.getMonth();
	var day1   = date1.getDay();

	var date2  = new Date();
	var year2  = date2.getYear();
	var month2 = date2.getMonth();
	var day2   = date2.getDay();

	var dt1 = new Date(year1, month1, day1);
	var dt2 = new Date(year2, month2, day2);
	var diff=(dt2.getTime() - dt1.getTime()) / 1000;
		diff /= (60 * 60 * 24 * 7 * 4);
	if(Math.abs(Math.round(diff)) <= 0)
		return "<i class='text-danger'>Contract Expired</i>";
	else
		return Math.abs(Math.round(diff));
}

$("#add-user").click(function(e){
	Pace.restart();
	Pace.track(function(){
		var html = '<div class="row"><div class="col-xs-12"><div class="box box-default"><div class="box-body"><div class="row"><div class="col-md-12"><div class="form-group"><label>Employee name</label><select class="form-control select2" id="employee-list"></select></div></div></div></div></div>';
		BootstrapDialog.show({
	        title: 'Grant access to Employee',
	        message: html,
	        onshown: function(e)
	        {
		        
		        	$.post("userList",{get_employees: "true"}, function(result){
		        		$(".bootstrap-dialog").removeAttr("tabindex");
						var options = "<option value=''>Select Employee..</option>";
						var data = jQuery.parseJSON(result);
						$.each(data, function(key, val){
							options += "<option value='"+this.emp_id+"' data-name='"+this.first_name+" "+this.last_name+"'>"+this.first_name+" "+this.last_name+"</options>";
						});
						$("#employee-list").append(options);
					});
		        	$(".select2").select2();

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
				            label: '<i class="fa fa-check-circle"></i>&nbsp;&nbsp; Grant Access',
				            cssClass: 'btn btn-sm btn-success pull-right',
				            id: 'grand-btn',
				            action: function(dialog) 
				            {
				        		var emp_id  = $("#employee-list").val();
				        		var fullname= $("#employee-list").select2().find(":selected").data("name");
				        		if(emp_id == "")
				        		{
				        			alertify.error("Employee name is required.");
				        		}
				        		else
				        		{
					        		Pace.restart();
									Pace.track(function(){
					        			$.post("userList", {grant_user: 'true', emp_id:emp_id}, function(r){
					        				if(r == 1)
					        				{
					        					alertify.success("Access granted to " + fullname);
					        					$("#grand-btn").attr('disabled','true');
					        					setTimeout(function(e){
					        						location.reload();
					        					}, 1500);
					        				}
					        				else
					        				{
					        					alertify.error("Error granting access to " + fullname);
					        				}
					        			});
					        		});
				        		}
				        	}
	        			}
	        		]
	    });
	});
}); //add grant access to employees

$(".remove-grant").click(function(e){
	var id = $(this).data('pk');
	$.confirm({
			    title: 'Warning!',
			    content: 'Remove access to this user?',
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
						    			$.post("userList", {id:id, remove_grant:'true'}, function(r){
						    				if(r == 1)
						    				{
						    					alertify.success("Access was successfully removed.");
						    					setTimeout(function(e){
						    						location.reload();
						    					}, 1500);
						    				}
						    				else
						    				{
						    					alertify.error("Error removing access.");
						    				}
										});
									});
								}
					        }						        
			    		}
			});
}); //remove access to ssg

$(".grant-access").click(function(e){
	var id = $(this).data('pk');
	$.confirm({
			    content: 'Grant access to this user?',
			    icon: 'fa fa-check',
			    type: 'green',
			 
			    buttons: {
			    			close: function () {
					        },
					        tryAgain: {
					            text: 'Confirm',
					            btnClass: 'btn-blue',
					            action: function()
					            {
						            Pace.restart();
									Pace.track(function(){
						    			$.post("userList", {id:id, grant_access:'true'}, function(r){
						    				if(r == 1)
						    				{
						    					alertify.success("Access was successfully added.");
						    					setTimeout(function(e){
						    						location.reload();
						    					}, 1500);
						    				}
						    				else
						    				{
						    					alertify.error("Error adding access.");
						    				}
										});
									});
								}
					        }						        
			    		}
			});
});	

//------------------------------- USER MODULES ------------------------------------------------>

$("#user-list").change(function(e){
	if($(this).val() == '')
	{
		$("#append-modules").html("<tr><td colspan='3' class='text-center'><i>Data not available..</i></td></tr>");
	}
	else
	{
		var id  = $(this).val();
		var html= ""; 
		$.post("userModules", {id:id, user_modules:'true'}, function(r){
			var data = jQuery.parseJSON(r);
			$.each(data, function(key, val){
				html += "<tr><td>"+this.parent_module.toUpperCase()+"</td><td>"+this.module_name.toUpperCase()+"</td>";
				if(this.is_set == 1)
					html +="<td class='text-center'><input type='checkbox' data-id='"+this.id+"' data-pk='"+this.module_id+"' class='flat-blue module-ssg' checked></td></tr>";
				else
					html +="<td class='text-center'><input type='checkbox' data-pk='"+this.module_id+"' class='flat-blue module-ssg' ></td></tr>";
			});
			$("#append-modules").html(html);
			$('.flat-blue').iCheck({
			   	checkboxClass: 'icheckbox_minimal-blue',
              	radioClass   : 'iradio_minimal-blue'
			});
		});
	}
});

//----------------- User modules tab ------->>
$(document).on('ifChecked','.module-ssg',function(e){
	var module_id = $(this).data('pk');
	var user_id   = $("#user-list").val();
	$.post("userModules", {add_module: 'true', module_id:module_id, user_id: user_id}, function(r){
		if(r == 1)
			alertify.success("Module added");
		else
			alertify.error("Error adding module.");
	});
});

$(document).on('ifUnchecked', '.module-ssg', function(event){
	var id = $(this).data('id');
	$.post("userModules", {remove_module: 'true', id:id}, function(r){
		if(r == 1)
			alertify.success("Module removed");
		else
			alertify.error("Error removing module.");
	});
});
//----------------- User modules tab ------->>

//----------------- User access tab ------->>
$(document).on('ifChecked','.update-access',function(e){
	var id   = $(this).data('pk');
	var type = $(this).data('value');
	$.post("userModules", {update_access: 'true', id:id, type: type, access:'true'}, function(r){
		if(r == 1)
			alertify.success("Access granted");
		else
			alertify.error("Error adding access.");
	});
});

$(document).on('ifUnchecked', '.update-access', function(event){
	var id   = $(this).data('pk');
	var type = $(this).data('value');
	$.post("userModules", {update_access: 'true', id:id, type: type, access:'false'}, function(r){
		if(r == 1)
			alertify.success("Access removed");
		else
			alertify.error("Error removing access.");
	});
});
//----------------- User access tab ------->>
import React, { Component } from 'react';
import axios from 'axios';
const $ = window.$;
var x = {
		cursor: 'pointer'
	};
var offset = 2;
class ShowLogs extends Component {
	seeMore = () => {
		$(".time-end").html("");
		axios.post('seeMoreLogs', {offset:offset}).then(function(response){
			let see_more = [];
			let data_array = [];
			console.log(response);
			for(var i = 0; i < response.data.query1.length; i++)
			{
				let temp = "";
				for(var j = 0; j < response.data.query2.length; j++)
				{
					if(response.data.query2[j]['created'] === response.data.query1[i]['created'])
					{
						temp = response.data.query2[j]['created'];
					}
				}
				if(temp !== "")
				{
					data_array.push(temp);
				}
			}
			for(var i = 0; i < data_array.length; i++)
			{
				let children = [];
				for(var j = 0; j < response.data.query2.length; j++)
				{
					if(response.data.query2[j]['created'] === data_array[i])
					{
						var action = '';
						if(response.data.query2[j]['action'] === 'add' || response.data.query2[j]['action'] === 'Add')
							action = '<i class="fa fa-plus bg-aqua"></i>';
						else if(response.data.query2[j]['action'] === 'delete')
							action = '<i class="fa fa-trash bg-red"></i>';
						else if(response.data.query2[j]['action'] === 'edit')
							action = '<i class="fa fa-edit bg-yellow"></i>';
						else
							action = '<i class="fa fa-o bg-blue"></i>';
						children.push('<li>'+action+'<div class="timeline-item"><span class="time"><i class="fa fa-clock-o"></i>'+response.data.query2[j]['time_log']+'</span><h3 class="timeline-header no-border"><small style="font-family: Century Gothic; font-size:17px; color: #272727; font-weight: normal;">'+response.data.query2[j]['log_details']+'</small></h3><div class="timeline-body"><h5><i class="fa  fa-thumb-tack"></i>  <b>Module: </b>'+response.data.query2[j]['module']+'</h5><h5><i class="fa  fa-home"></i>  <b>IP Address: </b>'+response.data.query2[j]['ip_address']+'</h5></div></div></li>');
					}
				}
				see_more.push('<li class="time-label"><span class="bg-green">'+data_array[i]+'</span></li>' + children.join(""));
			}
			offset++;
			see_more.push('<li class="time-end"><i class="fa fa-clock-o bg-gray"></i></li>');
			if(see_more.length <= 1)
			{
				$("#see-more").html("&nbsp;");
			}
			return $("#append-logs").append(see_more.join(''));
		});
	}
  	render() 
  	{
	    return (
	                <div>
	            		<medium className="text-primary" id="see-more" onClick={this.seeMore} style={x}><u>See more</u></medium>
	            		<medium className="pull-right text-primary" id="view-all" style={x}><u>View all</u></medium>
	                </div>
	        	);
  	}
}
export default ShowLogs;

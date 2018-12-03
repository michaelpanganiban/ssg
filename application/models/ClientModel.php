<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ClientModel extends CI_Model 
{
	public function getIndustries()
	{
		return $this->db->query('SELECT div_id, div_name FROM division')->result();
	}

	public function addClientModel()
	{
		$error = 0;
		$data = $this->db->query("SELECT MAX(client_id) as MAX FROM ssg_client")->result_array();
		$client_id = $data[0]['MAX'] + 1;

		$ref_no    = @date('Ymd').$client_id;
		$client    = $this->input->post('client');
		$client   += ['ref_no' => $ref_no];
		$contract  = $this->input->post('contract');
		$contract += ['client_id' => $client_id];
		$functions = $this->input->post('functions');
		for($i = 0; $i < sizeof($functions); $i++)
		{
			$functions[$i] += ['client_id' => $client_id];
		}
		$team = $this->input->post('team');
		for($i = 0; $i < sizeof($team); $i++)
		{
			$team[$i] += ['client_id' => $client_id];
		}
		$this->db->trans_start();
			$this->db->insert('ssg_client', $client);
			$this->db->insert('ssg_contracts', $contract);
			$id = $this->db->insert_id();
			$this->db->insert_batch('ssg_targets_and_actuals_line', $functions);
			$this->db->insert_batch('team', $team);
		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE)
			return 0;
		return array('contract_id' =>$id, 'client_id' => $client_id);
	}

	public function updateDoc($data)
	{
		$this->db->trans_start();
			$this->db->insert_batch('ssg_msa_uploads', $data);
		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE)
			return 0;
		return 1;		
	}

	public function updateDocNew($data, $counter)
	{
		$id = htmlspecialchars(trim($this->input->cookie('contract_id', TRUE)));
		$this->db->trans_start();
			$this->db->insert_batch('ssg_uploads_child', $data);
			$this->db->where('contract_line_id', $id);
			$this->db->update('ssg_contract_line', array('document' => $counter));
		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE)
			return 0;
		return 1;		
	}

	public function getContractList()
	{
		$id = htmlspecialchars(trim($this->input->post('id', TRUE)));
		return $this->db->query("SELECT contract_line_id, contract, DATE_FORMAT(start_date, '%Y-%m-%d') AS start_date, DATE_FORMAT(expiry_date, '%Y-%m-%d') as expiry_date, type, headcount, remarks, document FROM ssg_contract_line WHERE MSA = '$id'")->result();
	}

	public function getClientList()
	{
		return $this->db->query("SELECT c.*, d.div_name FROM ssg_client c LEFT JOIN division d ON c.division_id = d.div_id WHERE c.status = '1'")->result();
	}

	public function getParticularClient()
	{
		$id = htmlspecialchars(trim($this->uri->segment(3)));
		return $this->db->query("SELECT c.*, st.start_date, st.contract_id as team_line_id, st.contract, st.expiry_date, st.document, st.type, st.remarks, st.MSA, st.headcount FROM ssg_client c LEFT JOIN ssg_contracts st ON st.client_id = c.client_id WHERE c.client_id = '$id' AND c.status = '1'")->result();
	}

	public function deleteClient()
	{
		$id = htmlspecialchars(trim($this->input->post('id', TRUE)));
		$this->db->where('client_id', $id);
		if($this->db->update('ssg_client', array('status' => "0")))
			return 1;
		return 0;
	}

	public function removeTeamModel()
	{
		$id = htmlspecialchars(trim($this->input->post('id', TRUE)));
		$this->db->where('team_id', $id);
		if($this->db->delete('team'))
			return 1;
		return 0;
	}

	public function getParticularTeam()
	{
		$id = htmlspecialchars(trim($this->uri->segment(3)));
		return $this->db->query("SELECT team_id, team_name FROM team WHERE client_id = '$id'")->result();
	}

	public function getFilesMSA()
	{
		$and = "";
		if($this->input->post('get_files') == "true")
		{
			$id 	  = htmlspecialchars(trim($this->input->post('client_id', TRUE)));
			$contract = htmlspecialchars(trim($this->input->post('contract_id', TRUE)));
			$and = " AND contract_no = '$contract'";
		}
		else
		{
			$id = htmlspecialchars(trim($this->uri->segment(3)));
		}
		return $this->db->query("SELECT * FROM ssg_msa_uploads WHERE client_id = '$id' $and")->result();
	}

	public function getFilesChild()
	{
		$id 	  = htmlspecialchars(trim($this->input->post('client_id', TRUE)));
		$contract = htmlspecialchars(trim($this->input->post('contract_id', TRUE)));
		return $this->db->query("SELECT * FROM ssg_uploads_child WHERE client_id = '$id' AND contract_no = '$contract'")->result();
	}

	public function sumHeadCount()
	{
		$id = htmlspecialchars(trim($this->uri->segment(3)));
		return $this->db->query("SELECT SUM(billed_hc) AS headcount FROM ssg_targets_and_actuals_line WHERE client_id = '$id'")->result();
	}

	public function getHeadCount()
	{
		return $this->db->query("SELECT SUM(billed_hc) AS headcount, client_id FROM ssg_targets_and_actuals_line GROUP BY client_id")->result();
	}

	public function editClientModel()
	{
		$client   = $this->input->post('client');
		$client_id= $this->input->post('client_id');
		$team     = $this->input->post('team'); 
		$this->db->trans_start();
			$this->db->update_batch('team', $team, 'team_id');
			$this->db->where("client_id", $client_id);
			$this->db->update('ssg_client', $client);
		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE)
			return 0;
		return 1;
	}

	public function addTeamModel()
	{
		if($this->db->insert('team', array('client_id' => htmlspecialchars(trim($this->input->post('client_id', TRUE))))))
			return 1;
		return 0;
	}

	public function removeDoc()
	{
		$id    = htmlspecialchars(trim($this->input->post('id')));
		$table = "ssg_msa_uploads";
		$pk    = "file_no";
		if(!empty(htmlspecialchars(trim($this->input->post('remove2')))))
		{
			$count 	 = htmlspecialchars(trim($this->input->post('count_doc')), TRUE);
			$line_id = htmlspecialchars(trim($this->input->post('line_id')), TRUE);
			$table 	 = "ssg_uploads_child";
		}

		$this->db->trans_start();
			$this->db->where($pk, $id);
			$this->db->delete($table);
			if(!empty(htmlspecialchars(trim($this->input->post('remove2')))))
			{
				$this->db->where('contract_line_id', $line_id);
				$this->db->update('ssg_contract_line', array('document'=> $count));
			}
		$this->db->trans_complete();	
		if($this->db->trans_status() === FALSE)
			return 0;
		return 1;
	}

	public function getAnnex()
	{
		$id = htmlspecialchars(trim($this->input->post('id')));
		return $this->db->query("SELECT * FROM contract_line WHERE MSA = '$id'")->result();
	}

	public function addNewContract()
	{
		$contract = $this->input->post('contract', TRUE);
		$functions= $this->input->post('functions', TRUE);
		$action   = $this->input->post('action', TRUE);
		$client_id  = htmlspecialchars(trim($this->input->post('client_id', TRUE)));
		for($i = 0; $i < sizeof($functions); $i++)
		{
			$functions[$i] += ['client_id' => htmlspecialchars(trim($this->input->post('client_id', TRUE)))];
			if($action == 'deduct')
			{
				$functions[$i]['billed_hc'] = ($functions[$i]['billed_hc'] * -1);
				$functions[$i]['cost_per_title'] = ($functions[$i]['cost_per_title'] * -1);
				$functions[$i]['ttl_cost'] = ($functions[$i]['ttl_cost'] * -1);
			}
		}
		$this->db->trans_start();
			$this->db->insert('ssg_contract_line', $contract);
			$id = $this->db->insert_id();
			$this->db->insert_batch('ssg_targets_and_actuals_line', $functions);
		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE)
			return 0;
		return array('contract_id' => $id, 'client_id' => $client_id);
	}

	public function updateContract()
	{
		$child 	= $this->input->post('child', TRUE);
		$mother = $this->input->post('mother', TRUE);
		$id 	= $this->input->post('id', TRUE);
		$this->db->trans_start();
			$this->db->where('contract_id', $id);
			$this->db->update('ssg_contracts', $mother);
			if(!empty($child))
				$this->db->update_batch('ssg_contract_line', $child, 'contract_line_id');
		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE)
			return 0;
		return 1;
	}

	public function addMSA()
	{
		$contract = $this->input->post('contract', TRUE);
		$functions= $this->input->post('function', TRUE);
		$client_id  = htmlspecialchars(trim($this->input->post('id', TRUE)));
		for($i = 0; $i < sizeof($functions); $i++)
		{
			$functions[$i] += ['client_id' => htmlspecialchars(trim($this->input->post('id', TRUE)))];
		}

		$this->db->trans_start();
			$this->db->insert('ssg_contracts', $contract);
			$id = $this->db->insert_id();
			$this->db->insert_batch('ssg_targets_and_actuals_line', $functions);
		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE)
			return 0;
		return array('contract_id' => $id, 'client_id'=>$client_id);
	}



	public function getJobOrderList()
	{
		return $this->db->query("SELECT id as joborder_id, jobtitle as title FROM jobs")->result();
	}

	public function addTargets()
	{
		$client = $this->input->post('client');
		$target = $this->input->post('line');
		$id     = $this->input->post('id');
		$data   = $this->db->query("SELECT COUNT(team_id) AS COUNT FROM ssg_targets_and_actuals WHERE team_id = '$id'")->result_array();
		if($data[0]['COUNT'] == 0)
		{
			$client2 = $this->input->post('client2');
			$this->db->insert('ssg_targets_and_actuals', $client2);
		}
		
		if($this->db->insert('ssg_targets_and_actuals', $client) === true)
			$id = $this->db->insert_id();
		$data = array();
		for($i = 0; $i < sizeof($target); $i++)
		{
			$temp = array(
							't_a_id' 		=> $id,
							'function'		=> $target[$i]['function'],
							'billed_hc' 	=> $target[$i]['billed'],
							'cost_per_title'=> $target[$i]['cost'],
							'ttl_cost'		=> $target[$i]['ttl_cost'],
							'hours_work'	=> $target[$i]['hours'],
							'timezone'		=> $target[$i]['timezone'],
							'shift'			=> $target[$i]['shift'],
							'location'		=> $target[$i]['location']
						 );
			array_push($data, $temp);
		}
		$this->db->insert_batch('ssg_targets_and_actuals_line', $data);
		return 1;
	}

	public function getTargetAndActual()
	{
		$year   = @date('Y') + 1;
		return $this->db->query("SELECT SUM(January) AS January,SUM(February) AS February,SUM(March) AS March,SUM(April) AS April ,SUM(May) AS May,SUM(June) AS June,SUM(July) AS July,SUM(August) AS August,SUM(September) AS September,SUM(November) AS November,SUM(October) AS October,SUM(December) AS December, action, team_id FROM ssg_targets_and_actuals  WHERE year = '$year' GROUP BY January, February, March, April, May, June, July, August, September, October, November, December, team_id, action")->result();
	}

	public function getPrevTargetAndActual()
	{
		$current 	= @date('Y');
		return  $this->db->query("SELECT SUM(January) AS January,SUM(February) AS February,SUM(March) AS March,SUM(April) AS April ,SUM(May) AS May,SUM(June) AS June,SUM(July) AS July,SUM(August) AS August,SUM(September) AS September,SUM(November) AS November,SUM(October) AS October,SUM(December) AS December, team_id, action FROM ssg_targets_and_actuals WHERE year = '$current' GROUP BY team_id")->result();
	}

	public function getDetailed()
	{
		$id = htmlspecialchars(trim($this->input->post('id')));
		return $this->db->query("SELECT sl.*, SUM(sl.billed_hc) AS billed_hc, j.jobtitle as title FROM  ssg_targets_and_actuals_line sl LEFT JOIN jobs j ON sl.function = j.id WHERE sl.client_id = '$id' AND sl.function IS NOT NULL GROUP BY sl.function")->result();
	}

	public function addFunction()
	{
		if($this->db->insert('jobs', array('jobtitle'=>htmlspecialchars(trim($this->input->post('new_function'))))))
			return $this->db->insert_id();
		return 0;
	}
}


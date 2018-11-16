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
		$data = $this->db->query("SELECT MAX(team_id) as MAX FROM team")->result_array();
		$team_id = $data[0]['MAX'] + 1;

		$ref_no    = @date('Ymd').$team_id;
		$client    = $this->input->post('client');
		$client   += ['ref_no' => $ref_no];
		$contract  = $this->input->post('contract');
		$contract += ['team_id' => $team_id];
		$functions = $this->input->post('functions');
		for($i = 0; $i < sizeof($functions); $i++)
		{
			$functions[$i] += ['team_id' => $team_id];
		}
		
		$this->db->trans_start();
			$this->db->insert('team', $client);
			$this->db->insert('ssg_team_line', $contract);
			$id = $this->db->insert_id();
			$this->db->insert_batch('ssg_targets_and_actuals_line', $functions);
		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE)
			return 0;
		return $id;
	}

	public function updateDoc($name)
	{
		$contract_id = htmlspecialchars(trim($this->input->cookie('contract_id', TRUE)));
		$this->db->trans_start();
			$this->db->where('team_line_id', $contract_id);
			$this->db->update('ssg_team_line', array('document' => $name));
		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE)
			return 0;
		return 1;		
	}

	public function getClientList()
	{
		return $this->db->query('CALL clientlist()')->result();
	}

	public function getParticularClient()
	{
		$id = htmlspecialchars(trim($this->uri->segment(3)));
		return $this->db->query("SELECT t.*, st.team_line_id, st.start_date, st.team_line_id, st.contract, st.expiry_date, st.document, st.type, st.remarks, st.MSA, st.headcount FROM team t LEFT JOIN ssg_team_line st ON st.team_id = t.team_id WHERE t.team_id = '$id'")->result();
	}

	public function editClientModel()
	{
		$client = $this->input->post('client');
		$team_id= $this->input->post('team_id');
		$check  = $this->db->query("SELECT COUNT(team_line_id) AS COUNT FROM ssg_team_line WHERE team_id = '$team_id'")->result_array();
		
		$this->db->where("team_id", $team_id);
		$this->db->update('team', $client);
		$client_line = $this->input->post('client_line');
		if($check[0]['COUNT'] == 0)
		{
			$data = array();
			for($i = 0; $i < sizeof($client_line); $i++)
			{
				$temp = array(	
								'annex' 	 => $client_line[$i]['annex'],
								'start_date' => $client_line[$i]['start_date'],
								'expiry_date'=> $client_line[$i]['expiry_date'],
								'status' 	 => $client_line[$i]['status'],
								'next_step'  => $client_line[$i]['next_step'],
								'remarks' 	 => $client_line[$i]['remarks'],
								'team_id'	 => $team_id
							 );
				array_push($data, $temp);
			}
			$this->db->insert_batch('ssg_team_line', $data);
		}
		else
		{
			$this->db->update_batch('ssg_team_line', $client_line, 'team_line_id');
		}
		return 1;
	}

	public function removeDoc()
	{
		$id = htmlspecialchars(trim($this->input->post('id')));
		$this->db->trans_start();
			$this->db->where('team_line_id', $id);
			$this->db->update('ssg_team_line', array('document' => ""));
		$this->db->trans_complete();	
		if($this->db->trans_status() === FALSE)
			return 0;
		return 1;
	}

	public function getJobOrderList()
	{
		return $this->db->query("CALL joborderlist()")->result();
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
		return $this->db->query("SELECT sl.*, SUM(sl.billed_hc) AS billed_hc, j.jobtitle as title FROM ssg_targets_and_actuals sg LEFT JOIN ssg_targets_and_actuals_line sl ON sg.t_a_id = sl.t_a_id LEFT JOIN jobs j ON sl.function = j.id WHERE sg.team_id = '$id' AND sl.function IS NOT NULL GROUP BY sl.function")->result();
	}

	public function addFunction()
	{
		if($this->db->insert('jobs', array('jobtitle'=>htmlspecialchars(trim($this->input->post('new_function'))))))
			return $this->db->insert_id();
		return 0;
	}
	// public function getContractById()
	// {
	// 	$id = htmlspecialchars(trim($this->input->post('id', TRUE)));
	// 	return $this->db->query("SELECT contract, headcount, document, DATE_FORMAT(start_date, '%Y-%m-%d'), DATE_FORMAT(expiry_date, '%Y-%m-%d'), remarks,  FROM ssg_team_line WHERE team_line_id = '$id'")->result();
	// }
}


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

		$ref_no  = @date('Ymd').$team_id;
		$client  = $this->input->post('client');
		$client += ['ref_no' => $ref_no];

		$client_line = $this->input->post('client_line');
		for($i = 0; $i < sizeof($client_line); $i++)
		{
			$client_line[$i] += ['team_id' => $team_id];
		}

		if($this->db->insert('team', $client) != true)
			$error = 1;

		if($this->db->insert_batch('ssg_team_line', $client_line) != true)
			$error = 1;
		return $error;
	}

	public function getClientList()
	{
		return $this->db->query('CALL clientlist()')->result();
	}

	public function getParticularClient()
	{
		$id = htmlspecialchars(trim($this->uri->segment(3)));
		return $this->db->query("CALL particularclient($id)")->result();
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

	public function removeColumn()
	{
		$id = htmlspecialchars(trim($this->input->post('line_id')));
		$this->db->where('team_line_id', $id);
		if($this->db->delete('ssg_team_line') === true)
			return 1;
		return 0;
	}

	public function addColumnModel()
	{
		if($this->db->insert('ssg_team_line', array('team_id' => htmlspecialchars(trim($this->input->post('id'))))) === true)
			return $this->db->insert_id();
		return 0;
	}

	public function getJobOrderList()
	{
		return $this->db->query("CALL joborderlist()")->result();
	}

	public function addTargets()
	{
		$client = $this->input->post('client');
		$target = $this->input->post('line');
		
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
		$year   = @date('Y');
		return $this->db->query("SELECT t.team_name, COUNT(sg.target) AS target_count, sg.month, sg.action FROM ssg_targets_and_actuals sg LEFT JOIN team t ON t.team_id = sg.team_id WHERE sg.year = '$year' GROUP BY sg.month, sg.team_id")->result();
	}

	public function getPrevTargetAndActual()
	{
		$prev 	= @date('Y') - 1;
		return $this->db->query("SELECT t.team_name, COUNT(sg.target) AS target_count, sg.month, sg.action FROM ssg_targets_and_actuals sg LEFT JOIN team t ON t.team_id = sg.team_id WHERE sg.year = '$prev' GROUP BY sg.month, sg.team_id")->result();
	}
}
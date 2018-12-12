<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ClientReportModel extends CI_Model 
{
	public function getHeadCount()
	{
		$and = "";
		if(!empty(htmlspecialchars(trim($this->input->get('from', TRUE)))) && !empty(htmlspecialchars(trim($this->input->get('to', TRUE)))))
		{
			$from = htmlspecialchars(trim($this->input->get('from', TRUE)));
			$to   = htmlspecialchars(trim($this->input->get('to', TRUE)));
			$and  = " AND DATE_FORMAT(t.created, '%Y-%m-%d') BETWEEN '$from' AND '$to'";
		}

		if(!empty(htmlspecialchars(trim($this->input->get('client', TRUE)))) && htmlspecialchars(trim($this->input->get('client', TRUE))) != "undefined")
		{
			$client = htmlspecialchars(trim($this->input->get('client', TRUE)));
			$and  = " AND t.client_id = '$client'";
		}
		if(!empty(htmlspecialchars(trim($this->input->get('div_id', TRUE)))) && htmlspecialchars(trim($this->input->get('div_id', TRUE))) != "undefined")
		{
			$div_id = htmlspecialchars(trim($this->input->get('div_id', TRUE)));
			$and  = " AND c.division_id = '$div_id'";
		}
		return $this->db->query("SELECT t.*, SUM(t.billed_hc) as hc, j.jobtitle, c.client_name FROM ssg_targets_and_actuals_line t LEFT JOIN ssg_client c ON t.client_id = c.client_id LEFT JOIN jobs j ON t.function = j.id WHERE 1 $and GROUP BY t.function, t.client_id ORDER BY t.client_id")->result();
	}
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminReportsModel extends CI_Model 
{
	public function getUserLogs($id, $limit = 20, $offset = 0)
	{
		$query1 = $this->db->query("SELECT DISTINCT DATE_FORMAT(created, '%d %M %Y') AS created FROM ssg_user_logs WHERE emp_id = '$id' ORDER BY log_id DESC")->result();
		$query2 = $this->db->query("SELECT p.emp_id, p.last_name, p.first_name, sl.log_details, sl.module, sl.action, sl.ip_address, DATE_FORMAT(sl.created, '%d %M %Y') AS created, DATE_FORMAT(sl.created, '%h:%i %a') AS time_log FROM ssg_user_logs sl LEFT JOIN profile p ON sl.emp_id = p.emp_id WHERE sl.emp_id = '$id' ORDER BY sl.log_id DESC LIMIT $offset, $limit")->result();
		return array('query1' => $query1, 'query2' => $query2);
	}

	public function getAuthLogs($id)
	{
		if(!empty(htmlspecialchars(trim($this->input->get('from', TRUE)))) && !empty(htmlspecialchars(trim($this->input->get('to', TRUE)))))
		{
			$from = htmlspecialchars(trim($this->input->get('from', TRUE)));
			$to   = htmlspecialchars(trim($this->input->get('to', TRUE)));
			$and  = " AND DATE_FORMAT(ul.created, '%Y-%m-%d') BETWEEN '$from' AND '$to'";
		}
		else
		{
			$date = @date('Y-m-d');
			$and = " AND DATE_FORMAT(ul.created, '%Y-%m-%d') = '$date'";
		}

		if(!empty(htmlspecialchars(trim($this->input->get('user', TRUE)))) && htmlspecialchars(trim($this->input->get('user', TRUE))) != "undefined")
		{
			$user = htmlspecialchars(trim($this->input->get('user', TRUE)));
			$and  = " AND ul.user_id = '$user'";
		}
		else
		{
			$and = " AND ul.user_id = '$id'";
		}
		return $this->db->query("SELECT p.last_name, p.first_name, ul.user_id, ul.ip_address, ul.action, ul.result, ul.created FROM ssg_auth_logs ul LEFT JOIN profile p ON ul.user_id = p.emp_id WHERE 1 $and")->result();
	}
}
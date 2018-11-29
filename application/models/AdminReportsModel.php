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
}
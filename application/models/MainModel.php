<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MainModel extends CI_Model 
{
	public function login_model()
	{
		$username = htmlspecialchars(trim($this->input->post('username')));
		$password = htmlspecialchars(trim(md5($this->input->post('password'))));

		$query = $this->db->query("SELECT p.emp_id, p.first_name, p.last_name, e.date_hired, e.position, e.work_location FROM profile p LEFT JOIN employment e ON p.emp_id = e.emp_id WHERE p.emp_id = '$username' AND p.password = '$password' AND p.login_status='enabled' AND p.emp_id IN (SELECT emp_id FROM ssg_auth_login WHERE status = '1')");
		return $query->result();
	}


}
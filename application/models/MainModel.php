<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MainModel extends CI_Model 
{
	public function login_model()
	{
		$username = htmlspecialchars(trim($this->input->post('username')), TRUE);
		$password = htmlspecialchars(trim(md5($this->input->post('password'))), TRUE);

		$query = $this->db->query("SELECT p.emp_id, p.first_name, p.last_name, e.date_hired, e.position, e.work_location, sl.is_admin FROM profile p LEFT JOIN employment e ON p.emp_id = e.emp_id LEFT JOIN ssg_auth_login sl ON sl.emp_id = p.emp_id WHERE p.emp_id = '$username' AND p.password = '$password' AND p.login_status='enabled' AND p.emp_id IN (SELECT emp_id FROM ssg_auth_login WHERE status = '1')");
		return $query->result();
	}

	public function addActivityModel($data)
	{
		if($this->db->insert('ssg_user_logs', $data) === true)
			return 1;
		return 0;
	}

	public function getModuleList($id)
	{
		return $this->db->query("SELECT sm.parent_module, sm.module_name, sum.is_set, sum.view, sum.edit, sum.delete, sum.add, sm.level_one FROM ssg_user_modules sum LEFT JOIN ssg_modules sm ON sum.module_id = sm.module_id WHERE sum.user_id = '$id'")->result();
	}

	public function addAuthLogs($data)
	{
		if($this->db->insert('ssg_auth_logs', $data))
			return 1;
		return 0;
	}

	function validate_user_ldap($email)
	{
		$query = $this->db->query("SELECT p.emp_id, p.first_name, p.last_name, e.date_hired, e.position, e.work_location, sl.is_admin FROM profile p LEFT JOIN employment e ON p.emp_id = e.emp_id LEFT JOIN ssg_auth_login sl ON sl.emp_id = p.emp_id WHERE infinit_email like '$email%'  and (e.status = 14 or user_lvl=1) AND p.login_status='enabled' AND p.emp_id IN (SELECT emp_id FROM ssg_auth_login WHERE status = '1')");
		
		return $query->result();
	}
}


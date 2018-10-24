<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminModel extends CI_Model 
{
	public function getEmployeesList()
	{
		return $this->db->query("CALL getemployees()")->result();
	}

	public function getUserList()
	{
		return $this->db->query("CALL getuserlist()")->result();
	}

	public function grantAccess()
	{
		$data = array(
						'emp_id' 		=> htmlspecialchars(trim($this->input->post('emp_id'))),
						'status' 		=> '1',
						'date_created'	=> @date('Y-m-d')
					 );
		if($this->db->insert('ssg_auth_login', $data) === true)
			return 1;
		return 0;		
	}

	public function setAccess($type)
	{
		$id = htmlspecialchars(trim($this->input->post('id')));
		if($this->db->query("CALL setaccess($type, $id)") == true)
			return 1;
		return 0;
	}
}
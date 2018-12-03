<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminModel extends CI_Model 
{
	public function getEmployeesList()
	{
		return $this->db->query("SELECT p.emp_id, last_name, first_name FROM profile p WHERE p.emp_id NOT IN (SELECT sl.emp_id FROM ssg_auth_login sl)")->result();
	}

	public function getUserList()
	{
		return $this->db->query("SELECT sl.auth_id, sl.emp_id, sl.status, p.first_name, p.last_name, e.position, e.infinit_email, e.work_location FROM ssg_auth_login sl LEFT JOIN profile p ON sl.emp_id = p.emp_id LEFT JOIN employment e ON sl.emp_id = e.emp_id")->result();
	}

	public function getUserList2()
	{
		return $this->db->query("SELECT sl.auth_id, sl.emp_id, sl.status, p.first_name, p.last_name, e.position, e.infinit_email, e.work_location FROM ssg_auth_login sl LEFT JOIN profile p ON sl.emp_id = p.emp_id LEFT JOIN employment e ON sl.emp_id = e.emp_id")->result();
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

	public function getUserModules()
	{
		$id = htmlspecialchars(trim($this->input->post('id')));
		return $this->db->query("SELECT m.*, ml.is_set, ml.id FROM ssg_user_modules ml RIGHT JOIN ssg_modules m ON ml.module_id = m.module_id AND ml.user_id = '$id'")->result();
	}

	public function addModule()
	{
		$data = array(
						'module_id' => htmlspecialchars(trim($this->input->post('module_id'))),
						'is_set'	=> 1,
						'user_id'	=> htmlspecialchars(trim($this->input->post('user_id'))),						
					);
		if($this->db->insert('ssg_user_modules', $data) === true)
			return 1;
		return 0;
	}

	public function removeModule()
	{
		$id  = htmlspecialchars(trim($this->input->post('id')));
		$this->db->where('id', $id);
		if($this->db->delete('ssg_user_modules') === true)
			return 1;
		return 0;
	}

	public function getUserAccess()
	{
		return $this->db->query("SELECT sl.id, p.first_name, p.last_name, e.position, sl.view, sl.edit, sl.delete, sl.add, sm.module_name, p.emp_id FROM ssg_user_modules sl LEFT JOIN ssg_modules sm ON sl.module_id = sm.module_id LEFT JOIN profile p ON sl.user_id = p.emp_id LEFT JOIN employment e ON sl.user_id = e.emp_id ORDER BY sl.user_id DESC")->result();
	}

	public function updateAccess()
	{
		$id  = htmlspecialchars(trim($this->input->post('id')));
		$type= htmlspecialchars(trim($this->input->post('type')));
		if(htmlspecialchars(trim($this->input->post('access'))) == 'true')
			$update = 1;
		else
			$update = 0;
		$this->db->where('id', $id);
		if($this->db->update('ssg_user_modules', array($type => $update)) === true)
			return 1;
		return 0;
	}

	public function userListModel()
	{
		return $this->db->query("SELECT sl.auth_id, sl.emp_id, sl.status, p.first_name, p.last_name, e.position, e.infinit_email, e.work_location FROM ssg_auth_login sl LEFT JOIN profile p ON sl.emp_id = p.emp_id LEFT JOIN employment e ON sl.emp_id = e.emp_id")->result();
	}

	public function deleteUser()
	{
		$this->db->trans_start();
			$this->db->where('auth_id', htmlspecialchars(trim($this->input->post('id'))));
			$this->db->delete('ssg_auth_login');
			$this->db->where('user_id', htmlspecialchars(trim($this->input->post('emp_id'))));
			$this->db->delete('ssg_user_modules');
		$this->db->trans_complete();
		if($this->db->trans_status() === TRUE)
			return 1;
		return 0;		
	}
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminController extends MY_Controller 
{
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('AdminModel');
		$this->load->dbforge();
		$this->load->driver('cache', array('adapter' => 'file'));
    }

	public function userList()
	{
		if($ssg_session_data = $this->session->userdata('ssg_set_session'))
        {
	        if(!empty($this->input->post('get_employees')))
	        {
	        	$data = $this->AdminModel->getEmployeesList();
	        	echo json_encode($data);
	        }
	        else if(!empty($this->input->post('grant_user')))
	        {
	        	$this->cache->delete(md5('users'));
	        	$data = $this->AdminModel->grantAccess();
	        	echo $data;
	        }
	        else if(!empty($this->input->post('remove_grant')))
	        {
	        	$this->cache->delete(md5('users'));
	        	echo $this->AdminModel->setAccess(0);
	        }
	        else if(!empty($this->input->post('grant_access')))
	        {
	        	$this->cache->delete(md5('users'));
	        	echo $this->AdminModel->setAccess(1);
	        }
	        else
	        {
	        	$data['session'] = $ssg_session_data;
	        	$cache = md5('users');
				if(!$data['users'] = $this->cache->get($cache))
				{
					$data['users'] = $this->AdminModel->getUserList();
					$this->cache->save($cache, $data['users'], 3600);
				}
	        	$this->load->view('title_container');
	        	$this->load->view('header', $data);
	        	$this->load->view('Admin/userList');
	        	$this->load->view('footer');
	        }
        }
        else
        {
			redirect('','refresh');
		}
	}	

	public function userModules()
	{
		
	}
}

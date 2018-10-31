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
		if($ssg_session_data = $this->session->userdata('ssg_set_session'))
        {
	        $data['session'] = $ssg_session_data;
	        if(!empty($this->input->post('user_modules')))
	        {
				echo json_encode($this->AdminModel->getUserModules());
	        }
	        else if(!empty($this->input->post('add_module')))
	        {
	        	$this->cache->delete('user_modules');
	        	echo $this->AdminModel->addModule();
	        }
	        else if(!empty($this->input->post('remove_module')))
	        {
	        	$this->cache->delete('user_modules');
	        	echo $this->AdminModel->removeModule();
	        }
	        else if(!empty($this->input->post('update_access')))
	        {
	        	$this->cache->delete('user_modules');
	        	echo $this->AdminModel->updateAccess();
	        }
	       	else
	        {
	        	$cache = md5('users');
				if(!$data['users'] = $this->cache->get($cache))
				{
					$data['users'] = $this->AdminModel->userListModel();
					$this->cache->save($cache, $data['users'], 3600);
				}

				$cache = 'user_modules';
				if(!$data['user_modules'] = $this->cache->get($cache))
				{
					$data['user_modules'] = $this->AdminModel->getUserAccess();
					$this->cache->save($cache, $data['user_modules'], 3600);
				}
	        	$this->load->view('title_container');
	        	$this->load->view('header', $data);
	        	$this->load->view('Admin/userModules');
	        	$this->load->view('footer');
        	}
        }
        else
        {
			redirect('','refresh');
		}
	}
}

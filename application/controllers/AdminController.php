<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminController extends MY_Controller 
{
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('AdminModel');
		$this->load->model('MainModel');
		$this->load->dbforge();
		$this->load->driver('cache', array('adapter' => 'file'));
    }

	public function userList()
	{
		if($ssg_session_data = $this->session->userdata('ssg_set_session'))
        {
        	$data['session'] = $ssg_session_data;
	        if(!empty($this->input->post('get_employees')))
	        {
	        	$data = $this->AdminModel->getEmployeesList();
	        	echo json_encode($data);
	        }
	        else if(!empty($this->input->post('grant_user')))
	        {
	        	$this->cache->delete(md5('users'));
	        	//--------------------- LOGS --------------------
	        	$logs = array(
	        					'emp_id' 		=> $data['session'][md5('emp_id')],
	        					'log_details'	=> 'Access granted to '.ucwords(strtolower($this->input->post('name'))),
	        					'module'		=> 'Users',
	        					'particulars'	=> htmlspecialchars(trim($this->input->post('emp_id'))),
	        					'action'		=> 'Add',
	        					'ip_address'	=> $this->get_client_ip()
	        				);
	        	$this->MainModel->addActivityModel($logs);
	        	//--------------------- LOGS --------------------
	        	$data = $this->AdminModel->grantAccess();
	        	echo $data;
	        }
	        else if(!empty($this->input->post('remove_grant')))
	        {
	        	$this->cache->delete(md5('users'));
	        	//--------------------- LOGS --------------------
	        	$logs = array(
	        					'emp_id' 		=> $data['session'][md5('emp_id')],
	        					'log_details'	=> 'Access removed to '.ucwords(strtolower($this->input->post('name'))),
	        					'particulars'	=> htmlspecialchars(trim($this->input->post('emp_id'))),
	        					'module'		=> 'Users',
	        					'action'		=> 'delete',
	        					'ip_address'	=> $this->get_client_ip(),
	        				);
	        	$this->MainModel->addActivityModel($logs);
	        	//--------------------- LOGS --------------------
	        	echo $this->AdminModel->setAccess(0);
	        }
	        else if(!empty($this->input->post('grant_access')))
	        {
	        	//--------------------- LOGS --------------------
	        	$logs = array(
	        					'emp_id' 		=> $data['session'][md5('emp_id')],
	        					'log_details'	=> 'Access granted to '.ucwords(strtolower($this->input->post('name'))),
	        					'particulars'	=> htmlspecialchars(trim($this->input->post('emp_id'))),
	        					'module'		=> 'Users',
	        					'action'		=> 'Add',
	        					'ip_address'	=> $this->get_client_ip(),
	        				);
	        	$this->MainModel->addActivityModel($logs);
	        	//--------------------- LOGS --------------------
	        	$this->cache->delete(md5('users'));
	        	echo $this->AdminModel->setAccess(1);
	        }
	        else if(!empty($this->input->post('delete_user')))
	        {
	        	//--------------------- LOGS --------------------
	        	$logs = array(
	        					'emp_id' 		=> $data['session'][md5('emp_id')],
	        					'log_details'	=> ucwords(strtolower($this->input->post('name')))." has been removed to the system.",
	        					'particulars'	=> htmlspecialchars(trim($this->input->post('emp_id'))),
	        					'module'		=> 'Users',
	        					'action'		=> 'delete',
	        					'ip_address'	=> $this->get_client_ip(),
	        				);
	        	$this->MainModel->addActivityModel($logs);
	        	//--------------------- LOGS --------------------
	        	$this->cache->delete(md5('users'));
	        	echo $this->AdminModel->deleteUser();
	        }
	        else
	        {
	        	$cache = md5('users');
				if(!$data['users'] = $this->cache->get($cache))
				{
					$data['users'] = $this->AdminModel->getUserList();
					$this->cache->save($cache, $data['users'], 3600);
				}

				$data['user_modules'] = $this->restrict();
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
	        	//--------------------- LOGS --------------------
	        	$logs = array(
	        					'emp_id' 		=> $data['session'][md5('emp_id')],
	        					'log_details'	=> ucwords(strtolower($this->input->post('module')))." module has been added to ".htmlspecialchars(trim(ucwords(strtolower($this->input->post('name'))))),
	        					'particulars'	=> htmlspecialchars(trim($this->input->post('module_id'))),
	        					'module'		=> 'User Modules',
	        					'action'		=> 'Add',
	        					'ip_address'	=> $this->get_client_ip(),
	        				);
	        	$this->MainModel->addActivityModel($logs);
	        	//--------------------- LOGS --------------------
	        	$this->cache->delete('user_modules_list');
	        	if(htmlspecialchars(trim($this->input->post('user_id'))) == $data['session'][md5('emp_id')])
	        	{
	        		$id = $data['session'][md5('emp_id')];
	        		$this->cache->delete(md5($id.'user_modules'));
	        	}
	        	echo $this->AdminModel->addModule();
	        }
	        else if(!empty($this->input->post('remove_module')))
	        {
	        	//--------------------- LOGS --------------------
	        	$logs = array(
	        					'emp_id' 		=> $data['session'][md5('emp_id')],
	        					'log_details'	=> ucwords(strtolower($this->input->post('module')))." module has been removed to ".htmlspecialchars(trim(ucwords(strtolower($this->input->post('name'))))),
	        					'particulars'	=> htmlspecialchars(trim($this->input->post('module_id'))),
	        					'module'		=> 'User Modules',
	        					'action'		=> 'delete',
	        					'ip_address'	=> $this->get_client_ip(),
	        				);
	        	$this->MainModel->addActivityModel($logs);
	        	//--------------------- LOGS --------------------
	        	$this->cache->delete('user_modules_list');
	        	if(htmlspecialchars(trim($this->input->post('user_id'))) == $data['session'][md5('emp_id')])
	        	{
	        		$id = $data['session'][md5('emp_id')];
	        		$this->cache->delete(md5($id.'user_modules'));
	        	}
	        	echo $this->AdminModel->removeModule();
	        }
	        else if(!empty($this->input->post('update_access')))
	        {
	        	//--------------------- LOGS --------------------
	        	$what  = 'removed';
	        	$action= 'delete';
	        	if(htmlspecialchars(trim($this->input->post('access') == 'true')))
	        	{
	        		$what   = 'added';
	        		$action = 'add';
	        	}
	        	$logs = array(
	        					'emp_id' 		=> $data['session'][md5('emp_id')],
	        					'log_details'	=> ucwords(strtolower($this->input->post('type')))." access has been ".$what." to ".htmlspecialchars(trim($this->input->post('name'))).", for module ".htmlspecialchars(trim($this->input->post('module'))),
	        					'particulars'	=> htmlspecialchars(trim($this->input->post('type'))),
	        					'module'		=> 'User Access',
	        					'action'		=> $action,
	        					'ip_address'	=> $this->get_client_ip(),
	        				);
	        	$this->MainModel->addActivityModel($logs);
	        	//--------------------- LOGS --------------------
	        	$this->cache->delete('user_modules_list');
	        	if(htmlspecialchars(trim($this->input->post('user_id'))) == $data['session'][md5('emp_id')])
	        	{
	        		$id = $data['session'][md5('emp_id')];
	        		$this->cache->delete(md5($id.'user_modules'));
	        	}
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

				$cache = 'user_modules_list';
				if(!$data['user_modules_list'] = $this->cache->get($cache))
				{
					$data['user_modules_list'] = $this->AdminModel->getUserAccess();
					$this->cache->save($cache, $data['user_modules_list'], 3600);
				}

				$data['user_modules'] = $this->restrict();
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

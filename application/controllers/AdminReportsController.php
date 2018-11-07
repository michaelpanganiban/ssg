<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminReportsController extends MY_Controller 
{
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('AdminModel');
		$this->load->model('MainModel');
		$this->load->dbforge();
		$this->load->driver('cache', array('adapter' => 'file'));
    }

    public function userActivityLogs()
    {
    	if($ssg_session_data = $this->session->userdata('ssg_set_session'))
        {
        	$data['session'] = $ssg_session_data;
	        if(!empty($this->input->post('get_employees')))
	        {
	        	$data = $this->AdminModel->getEmployeesList();
	        	echo json_encode($data);
	        }
	        else
	        {
	        	$cache = md5('users');
				if(!$data['users'] = $this->cache->get($cache))
				{
					$data['users'] = $this->AdminModel->getUserList();
					$this->cache->save($cache, $data['users'], 3600);
				}
	        	$this->load->view('title_container');
	        	$this->load->view('header', $data);
	        	$this->load->view('Reports/userActivityLogs');
	        	$this->load->view('footer');
	        }
        }
        else
        {
			redirect('','refresh');
		}
    }
	
}

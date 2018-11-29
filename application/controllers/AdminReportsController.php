<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminReportsController extends MY_Controller 
{
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('AdminModel');
		$this->load->model('AdminReportsModel');
		$this->load->dbforge();
		$this->load->driver('cache', array('adapter' => 'file'));
    }

    public function userActivityLogs()
    {
    	if($ssg_session_data = $this->session->userdata('ssg_set_session'))
        {
        	$data['session'] = $ssg_session_data;
        	$id = $data['session'][md5('emp_id')];
        	$cache = md5('users');
			if(!$data['users'] = $this->cache->get($cache))
			{
				$data['users'] = $this->AdminModel->getUserList2();
				$this->cache->save($cache, $data['users'], 3600);
			}
			$data['logs'] = $this->AdminReportsModel->getUserLogs($id, 20, 0);
        	$this->load->view('title_container');
        	$this->load->view('header', $data);
        	$this->load->view('Reports/userActivityLogs');
        	$this->load->view('footer');
        }
        else
        {
			redirect('','refresh');
		}
    }

    public function seeMoreLogs()
    {
    	if($ssg_session_data = $this->session->userdata('ssg_set_session'))
        {
        	$data['session'] = $ssg_session_data;
        	$id = $data['session'][md5('emp_id')];
        	$obj = json_decode(file_get_contents('php://input'), true);
            $x = $obj['offset'] * 20;
    		echo json_encode($this->AdminReportsModel->getUserLogs($id, 20, $x));
        }
        else
        {
			redirect('','refresh');
		}
    }
}

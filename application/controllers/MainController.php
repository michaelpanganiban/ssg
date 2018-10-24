<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MainController extends MY_Controller
{
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('MainModel');
		$this->load->dbforge();
		$this->load->driver('cache', array('adapter' => 'file'));
    }

	public function index()
	{
		if($ssg_session_data = $this->session->userdata('ssg_set_session'))
        {
        	$data['session'] = $ssg_session_data;
        	$this->load->view('title_container');
        	$this->load->view('header', $data);
        	$this->load->view('home');
        	$this->load->view('footer');
        }
        else
        {
			$this->load->view('login'); 
		}
	}

	public function logout()
	{
		session_destroy();
		redirect('','refresh');
	}

	public function login()
	{
		if($ssg_session_data = $this->session->userdata('ssg_set_session'))
        {
        	redirect('MainController/home','refresh');
        }
        else
        {
			$data = $this->MainModel->login_model();
			$ssg_session_array = array();
			if(sizeof($data) > 0)
			{
				foreach($data as $row)
				{
					$ssg_session_array = array(
												'emp_id'  	 => $row->emp_id,
												'fullname' 	 => $row->last_name.", ".$row->first_name,
												'hired_date' => $row->date_hired,
												'position'	 => $row->position,
												'location'	 => $row->work_location
											  );
				}
	   			$ssg_session_data = $this->session->set_userdata('ssg_set_session', $ssg_session_array);
				echo 1;
			}
			else
			{
				echo 0;
			}
		}
	}

	public function home()
	{
		if($ssg_session_data = $this->session->userdata('ssg_set_session'))
        {
        	$data['session'] = $ssg_session_data;
        	$this->load->view('title_container');
        	$this->load->view('header', $data);
        	$this->load->view('home');
        	$this->load->view('footer');
        }
        else
        {
			redirect('','refresh');
		}
	}
}

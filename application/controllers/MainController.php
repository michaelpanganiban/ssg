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
        	$data['user_modules'] = $this->restrict();
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
		$ssg_session_data = $this->session->userdata('ssg_set_session');
		$data['session'] = $ssg_session_data;
        $id = $data['session'][md5('emp_id')];
		$this->cache->delete(md5($id.'user_modules'));
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
												md5('emp_id')  	 	 => $row->emp_id,
												md5('fullname') 	 => $row->last_name.", ".$row->first_name,
												md5('hired_date') 	 => $row->date_hired,
												md5('position')	 	 => $row->position,
												md5('location')	 	 => $row->work_location,
												md5('is_admin')	 	 => $row->is_admin
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

	// public function login()
	// {
	// 	if($ssg_session_data = $this->session->userdata('ssg_set_session'))
 //        {
 //        	redirect('MainController/home','refresh');
 //        }
 //        else
 //        {
	// 		$data = $this->MainModel->login_model();
	// 		$ssg_session_array = array();
	// 		if(sizeof($data) > 0)
	// 		{
	// 			foreach($data as $row)
	// 			{
	// 				$ssg_session_array = array(
	// 											md5('emp_id')  	 	 => $row->emp_id,
	// 											md5('fullname') 	 => $row->last_name.", ".$row->first_name,
	// 											md5('hired_date') 	 => $row->date_hired,
	// 											md5('position')	 	 => $row->position,
	// 											md5('location')	 	 => $row->work_location,
	// 											md5('is_admin')	 	 => $row->is_admin
	// 										  );
	// 			}
	//    			$ssg_session_data = $this->session->set_userdata('ssg_set_session', $ssg_session_array);
	// 			echo 1;
	// 		}
	// 		else
	// 		{
	// 			echo 0;
	// 		}
	// 	}
	// }

	public function home()
	{
		if($ssg_session_data = $this->session->userdata('ssg_set_session'))
        {
        	$data['session'] = $ssg_session_data;
        	$data['user_modules'] = $this->restrict();
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

	public function forgotPassword()
	{
		$this->load->library('email');

		$this->email->from('johnmichaelpanganiban.its@gmail.com', 'John Michael Panganiban');
		$this->email->to('johnmichaelpanganiban.its@gmail.com');
		// $this->email->cc('another@another-example.com');
		// $this->email->bcc('them@their-example.com');

		$this->email->subject('Email Test');
		$this->email->message('Testing the email class.');

		$this->email->send();
	}
}

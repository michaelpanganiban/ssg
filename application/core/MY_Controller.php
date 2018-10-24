<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
	public function __construct() 
	{
		parent::__construct();
		$data = array();
		$ssg_session_data = $this->session->userdata('ssg_set_session');
		$data['session'] = $ssg_session_data;
		if(!empty($data['session']))
		{
			// var_dump($data);
		} 
		//restrict login of users here
    }
}
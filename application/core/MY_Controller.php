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

    public function restrict()
    {
    	$ssg_session_data = $this->session->userdata('ssg_set_session');
    	$data['session'] = $ssg_session_data;
    	$id = $data['session'][md5('emp_id')];
    	$cache = md5($id.'user_modules');
		if(!$data['user_modules'] = $this->cache->get($cache))
		{
			$data['user_modules'] = $this->MainModel->getModuleList($id);
			$this->cache->save($cache, $data['user_modules'], 3600);
		}
		return $data['user_modules'];
    }

    public function get_client_ip() 
    {
	    $ipaddress = '';
	    if (getenv('HTTP_CLIENT_IP'))
	        $ipaddress = getenv('HTTP_CLIENT_IP');
	    else if(getenv('HTTP_X_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	    else if(getenv('HTTP_X_FORWARDED'))
	        $ipaddress = getenv('HTTP_X_FORWARDED');
	    else if(getenv('HTTP_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_FORWARDED_FOR');
	    else if(getenv('HTTP_FORWARDED'))
	       $ipaddress = getenv('HTTP_FORWARDED');
	    else if(getenv('REMOTE_ADDR'))
	        $ipaddress = getenv('REMOTE_ADDR');
	    else
	        $ipaddress = 'UNKNOWN';
	    return $ipaddress;
	}
}
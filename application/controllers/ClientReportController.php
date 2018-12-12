<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ClientReportController extends MY_Controller 
{
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('AdminModel');
		$this->load->model('ClientReportModel');
        $this->load->model('ClientModel');
		$this->load->dbforge();
		$this->load->driver('cache', array('adapter' => 'file'));
    }

    public function headCountReport()
    {
        if($ssg_session_data = $this->session->userdata('ssg_set_session'))
        {
            $data['session'] = $ssg_session_data;
            $id = $data['session'][md5('emp_id')];
            $cache = md5('clients');
            if(!$data['clients'] = $this->cache->get($cache))
            {
                $data['clients'] = $this->ClientModel->getClientList();
                $this->cache->save($cache, $data['clients'], 3600);
            }
            $data['user_modules'] = $this->restrict();
            $data['headcount']    = $this->ClientReportModel->getHeadCount();
            $data['division']= $this->ClientModel->getIndustries();
            if($this->input->get('save', TRUE) == 'pdf')
            {
                $this->load->view('Reports/client/headcount-PDF', $data);
            }
            if($this->input->get('save', TRUE) == 'excel')
            {
                $this->load->view('Reports/client/headcount-EXCEL', $data);
            }
            else
            {
                $this->load->view('title_container');
                $this->load->view('header', $data);
                $this->load->view('Reports/client/headCountReport');
                $this->load->view('footer');
            }
        }
        else
        {
            redirect('','refresh');
        }
    }
    
}

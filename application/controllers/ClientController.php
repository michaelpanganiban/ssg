<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ClientController extends MY_Controller 
{
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('ClientModel');
		$this->load->dbforge();
		$this->load->driver('cache', array('adapter' => 'file'));
    }

    public function client()
    {
    	if($ssg_session_data = $this->session->userdata('ssg_set_session'))
        {
	        $data['session'] = $ssg_session_data;
	     	$cache = md5('clients');
			if(!$data['clients'] = $this->cache->get($cache))
			{
				$data['clients'] = $this->ClientModel->getClientList();
				$this->cache->save($cache, $data['clients'], 3600);
			}
        	$this->load->view('title_container');
	    	$this->load->view('header', $data);
	    	$this->load->view('client/ClientList');
	    	$this->load->view('footer');
        }
        else
        {
			redirect('','refresh');
		}
    }

    public function addClient()
    {
    	if($ssg_session_data = $this->session->userdata('ssg_set_session'))
        {
        	$data['session'] = $ssg_session_data;
	        if($this->input->post('add') == "true")
	        {
	        	//--------------------- LOGS --------------------
	        	$logs = array(
	        					'emp_id' 		=> $data['session'][md5('emp_id')],
	        					'log_details'	=> "Client added",
	        					'particulars'	=> "",
	        					'module'		=> 'Client list',
	        					'ip_address'	=> $this->get_client_ip(),
	        				);
	        	$this->MainModel->addActivityModel($logs);
	        	//--------------------- LOGS --------------------
	        	$this->cache->delete(md5('clients'));
	        	$data = $this->ClientModel->addClientModel();
	        	echo json_encode($data);
	        }
	        else
	        {
	        	$data['session'] = $ssg_session_data;
	        	$data['division']= $this->ClientModel->getIndustries();
	        	$this->load->view('title_container');
		    	$this->load->view('header', $data);
		    	$this->load->view('client/addNewClient');
		    	$this->load->view('footer');
        	}
        }
        else
        {
			redirect('','refresh');
		}
    }

    public function editClient()
    {
    	if($ssg_session_data = $this->session->userdata('ssg_set_session'))
        {
        	$data['session'] = $ssg_session_data;
        	
	        if($this->input->post('edit') == "true")
	        {
	        	//--------------------- LOGS --------------------
		        	$logs = array(
		        					'emp_id' 		=> $data['session'][md5('emp_id')],
		        					'log_details'	=> "Client has been edited",
		        					'particulars'	=> htmlspecialchars(trim($this->input->post('team_id'))),
		        					'module'		=> 'Client list',
		        					'ip_address'	=> $this->get_client_ip(),
		        				);
		        	$this->MainModel->addActivityModel($logs);
		        //--------------------- LOGS --------------------
	        	$this->cache->delete(md5('clients'));
	        	$data = $this->ClientModel->editClientModel();
	        	echo json_encode($data);
	        }
	        else if($this->input->post('remove_line') == "true")
	        {
	        	$this->cache->delete(md5('clients'));
	        	$data = $this->ClientModel->removeColumn();
	        	echo $data;
	        }
	        else if($this->input->post('add_column') == "true")
	        {
	        	$this->cache->delete(md5('clients'));
	        	$data = $this->ClientModel->addColumnModel();
	        	echo $data;
	        }
	        else
	        {
	        	$data['session'] 	= $ssg_session_data;
	        	$data['division']   = $this->ClientModel->getIndustries();
	        	$data['client_data']= $this->ClientModel->getParticularClient();
	        	$this->load->view('title_container');
		    	$this->load->view('header', $data);
		    	$this->load->view('client/editClient');
		    	$this->load->view('footer');
        	}
        }
        else
        {
			redirect('','refresh');
		}
    }

    public function targetsAndActuals()
    {
    	if($ssg_session_data = $this->session->userdata('ssg_set_session'))
        {
        	$data['session'] 	= $ssg_session_data;
		    if($this->input->post('joborder_list') == 'true')
		    {
		    	echo json_encode($this->ClientModel->getJobOrderList());
		    }
		    else if($this->input->post('client_list') == "true")
		    {
		    	if(!$data['clients'] = $this->cache->get(md5('clients')))
				{
					$data['clients'] = $this->ClientModel->getClientList();
					$this->cache->save(md5('clients'), $data['clients'], 3600);
				}
		    	echo json_encode($data['clients']);
		    }
		    else if($this->input->post('add_function') == "true")
		    {
		    	//--------------------- LOGS --------------------
		        	$logs = array(
		        					'emp_id' 		=> $data['session'][md5('emp_id')],
		        					'log_details'	=> "Added new function",
		        					'particulars'	=> "",
		        					'module'		=> 'Targets and actuals',
		        					'ip_address'	=> $this->get_client_ip(),
		        				);
		        	$this->MainModel->addActivityModel($logs);
		        //--------------------- LOGS --------------------
		    	echo json_encode($this->ClientModel->addFunction());
		    }
		    else if($this->input->post('add') == 'true')
		    {
		    	//--------------------- LOGS --------------------
		        	$logs = array(
		        					'emp_id' 		=> $data['session'][md5('emp_id')],
		        					'log_details'	=> "Added new target",
		        					'particulars'	=> "",
		        					'module'		=> 'Targets and actuals',
		        					'ip_address'	=> $this->get_client_ip(),
		        				);
		        	$this->MainModel->addActivityModel($logs);
		        //--------------------- LOGS --------------------
		    	$this->cache->delete(md5('targets'));
		    	$this->cache->delete(md5('current'));
		    	echo $this->ClientModel->addTargets();
		    }
		    else if($this->input->post('get_detailed') == 'true')
		    {
		    	echo json_encode($this->ClientModel->getDetailed());
		    }
		    else
		    {
		        $cache = md5('targets');
				if(!$data['targets'] = $this->cache->get($cache))
				{
					$data['targets'] = $this->ClientModel->getTargetAndActual();
					$this->cache->save($cache, $data['targets'], 3600);
				}
				$cache = md5('current');
				if(!$data['current'] = $this->cache->get($cache))
				{
					$data['current'] = $this->ClientModel->getPrevTargetAndActual();
					$this->cache->save($cache, $data['current'], 3600);
				}
				if(!$data['clients'] = $this->cache->get(md5('clients')))
				{
					$data['clients'] = $this->ClientModel->getClientList();
					$this->cache->save(md5('clients'), $data['clients'], 3600);
				}
				$this->load->view('title_container');
		    	$this->load->view('header', $data);
		    	$this->load->view('client/targetsAndActuals');
		    	$this->load->view('footer');
		    }
        }
        else
        {
			redirect('','refresh');
		}
    }
}

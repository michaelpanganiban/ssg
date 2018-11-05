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
	        if($this->input->post('add') == "true")
	        {
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
	        if($this->input->post('edit') == "true")
	        {
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
		    	echo json_encode($this->ClientModel->addFunction());
		    }
		    else if($this->input->post('add') == 'true')
		    {
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
		        $data['session'] 	= $ssg_session_data;
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

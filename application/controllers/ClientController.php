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

			$data['headcount'] = $this->ClientModel->getHeadCount();
			$data['user_modules'] = $this->restrict();
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
	        	error_reporting(0);
	        	
	        	$this->cache->delete(md5('clients'));
	        	$res = $this->ClientModel->addClientModel();
	        	//--------------------- LOGS --------------------
	        	$logs = array(
	        					'emp_id' 		=> $data['session'][md5('emp_id')],
	        					'log_details'	=> ucwords(strtolower($this->input->post('client_name')))." client has been added.",
	        					'particulars'	=> "",
	        					'module'		=> 'Client list',
	        					'action'		=> 'Add',
	        					'ip_address'	=> $this->get_client_ip(),
	        				);
	        	$this->MainModel->addActivityModel($logs);
	        	//--------------------- LOGS --------------------
	        	echo json_encode($res);
	        }
	        else
	        {
	        	$data['session'] = $ssg_session_data;
	        	$data['division']= $this->ClientModel->getIndustries();
	        	$data['function']= $this->ClientModel->getJobOrderList();
	        	$data['user_modules'] = $this->restrict();
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

    public function uploadDoc()
    {
    	if($ssg_session_data = $this->session->userdata('ssg_set_session'))
        {
        	if(!empty($_FILES['sup_doc']['type']))
	    	{
	    		$data  = array();
	    		$dir   = "./assets/uploads_msa/";
				for($i = 0; $i < count($_FILES['sup_doc']['tmp_name']); $i++)
				{
					if($_FILES['sup_doc']['type'][$i] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet")
		    			$name = $_FILES['sup_doc']['name'][$i]."-".@date('Ymdhsi').".xlsx";
		    		else if($_FILES['sup_doc']['type'][$i] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
		    			$name = $_FILES['sup_doc']['name'][$i]."-".@date('Ymdhsi').".docx";
		    		else
		    			$name  =$_FILES['sup_doc']['name'][$i]."-". @date('Ymdhsi').".".basename($_FILES['sup_doc']['type'][$i]);

		    		$file = $dir.$name;
					if(move_uploaded_file($_FILES['sup_doc']['tmp_name'][$i], $file))
					{
						$temp = array(
										'contract_no' => htmlspecialchars(trim($this->input->cookie('contract_id', TRUE))),
										'team_id'	  => htmlspecialchars(trim($this->input->cookie('team_id', TRUE))),
										'filename'	  => $name
									);
						array_push($data, $temp);
					}
				}
    			echo $this->ClientModel->updateDoc($data);
    		}
    		else if(!empty($_FILES['sup_doc_new']['type']))
	    	{
	    		$dir   	= "./assets/uploads_child/";
	    		$data  	= array();
	    		$counter= htmlspecialchars(trim($this->input->cookie('counter', TRUE)));
	    		for($i = 0; $i < count($_FILES['sup_doc_new']['tmp_name']); $i++)
				{
					if($_FILES['sup_doc_new']['type'][$i] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet")
		    			$name = $_FILES['sup_doc_new']['name'][$i]."-".@date('Ymdhsi').".xlsx";
		    		else if($_FILES['sup_doc_new']['type'][$i] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
		    			$name = $_FILES['sup_doc_new']['name'][$i]."-".@date('Ymdhsi').".docx";
		    		else
		    			$name  =$_FILES['sup_doc_new']['name'][$i]."-". @date('Ymdhsi').".".basename($_FILES['sup_doc_new']['type'][$i]);

		    		$file = $dir.$name;
					if(move_uploaded_file($_FILES['sup_doc_new']['tmp_name'][$i], $file))
					{
						$temp = array(
										'contract_no' => htmlspecialchars(trim($this->input->cookie('contract_id', TRUE))),
										'team_id'	  => htmlspecialchars(trim($this->input->cookie('team_id', TRUE))),
										'filename'	  => $name
									);
						array_push($data, $temp);
					}
				}
    			echo $this->ClientModel->updateDocNew($data, $counter);
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
		        					'log_details'	=> ucwords(strtolower($this->input->post('client_name')))." client has been edited",
		        					'particulars'	=> htmlspecialchars(trim($this->input->post('team_id'))),
		        					'module'		=> 'Client list',
		        					'action'		=> 'edit',
		        					'ip_address'	=> $this->get_client_ip(),
		        				);
		        	$this->MainModel->addActivityModel($logs);
		        //--------------------- LOGS --------------------
	        	$this->cache->delete(md5('clients'));
	        	$data = $this->ClientModel->editClientModel();
	        	echo json_encode($data);
	        }
	        else if($this->input->post('remove_doc') == "true")
	        {
	        	$filename = FCPATH.'assets/uploads_msa/'.$this->input->post('filename');
	        	unlink($filename);
	        	$data = $this->ClientModel->removeDoc();
	        	echo $data;
	        }
	        else if($this->input->post('remove_doc2') == "true")
	        {
	        	$data = $this->ClientModel->removeDoc();
	        	$filename = FCPATH.'assets/uploads_child/'.$this->input->post('filename');
	        	unlink($filename);
	        	echo $data;
	        }
	        else if($this->input->post('new_contract') == "true")
	        {
	        	echo json_encode($this->ClientModel->addNewContract());
	        }
	        else if($this->input->post('get_annex') == "true")
	        {
	        	echo json_encode($this->ClientModel->getAnnex());
	        }
	        else if($this->input->post('contract_list') == "true")
	        {
	        	echo json_encode($this->ClientModel->getContractList());
	        }
	        else if($this->input->post('update_contract') == "true")
	        {
	        	echo json_encode($this->ClientModel->updateContract());
	        }
	        else if($this->input->post('add_msa') == "true")
	        {
	        	echo json_encode($this->ClientModel->addMSA());
	        }
	        else if($this->input->post('get_files') == "true")
	        {
	        	echo json_encode($this->ClientModel->getFilesMSA());
	        }
	        else if($this->input->post('get_files_child') == "true")
	        {
	        	echo json_encode($this->ClientModel->getFilesChild());
	        }
	        else
	        {
	        	$data['session'] 	= $ssg_session_data;
	        	$data['division']   = $this->ClientModel->getIndustries();
	        	$data['client_data']= $this->ClientModel->getParticularClient();
	        	$data['headcount']  = $this->ClientModel->sumHeadCount();
	        	$data['files']		= $this->ClientModel->getFilesMSA();
	        	$data['user_modules'] = $this->restrict();
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

    public function manageContract()
    {
    	if($ssg_session_data = $this->session->userdata('ssg_set_session'))
        {
        	$data['session'] = $ssg_session_data;
        	if($this->input->post('get_each') == 'true')
        	{
        		echo json_encode($this->ClientModel->getContractById());
        	}

        }
        else
        {
			redirect('','refresh');
		}
    }

    public function getDetailedHeadCount()
    {
    	echo json_encode($this->ClientModel->getDetailed());
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
		        					'log_details'	=> ucwords(strtolower($this->input->post('new_function')))." has been added to jobs",
		        					'particulars'	=> "",
		        					'module'		=> 'Targets and actuals',
		        					'action'		=> 'Add',
		        					'ip_address'	=> $this->get_client_ip(),
		        				);
		        	$this->MainModel->addActivityModel($logs);
		        //--------------------- LOGS --------------------
		    	echo json_encode($this->ClientModel->addFunction());
		    }
		  //   else if($this->input->post('add') == 'true')
		  //   {
		  //   	//--------------------- LOGS --------------------
		  //       	$logs = array(
		  //       					'emp_id' 		=> $data['session'][md5('emp_id')],
		  //       					'log_details'	=> "Added new target to client ".ucwords(strtolower($this->input->post('client_name'))),
		  //       					'particulars'	=> "",
		  //       					'module'		=> 'Targets and actuals',
		  //       					'action'		=> 'Add',
		  //       					'ip_address'	=> $this->get_client_ip(),
		  //       				);
		  //       	$this->MainModel->addActivityModel($logs);
		  //       //--------------------- LOGS --------------------
		  //   	$this->cache->delete(md5('targets'));
		  //   	$this->cache->delete(md5('current'));
		  //   	echo $this->ClientModel->addTargets();
		  //   }
		  //   else if($this->input->post('get_detailed') == 'true')
		  //   {
		  //   	echo json_encode($this->ClientModel->getDetailed());
		  //   }
		  //   else
		  //   {
		  //       $cache = md5('targets');
				// if(!$data['targets'] = $this->cache->get($cache))
				// {
				// 	$data['targets'] = $this->ClientModel->getTargetAndActual();
				// 	$this->cache->save($cache, $data['targets'], 3600);
				// }
				// $cache = md5('current');
				// if(!$data['current'] = $this->cache->get($cache))
				// {
				// 	$data['current'] = $this->ClientModel->getPrevTargetAndActual();
				// 	$this->cache->save($cache, $data['current'], 3600);
				// }
				// if(!$data['clients'] = $this->cache->get(md5('clients')))
				// {
				// 	$data['clients'] = $this->ClientModel->getClientList();
				// 	$this->cache->save(md5('clients'), $data['clients'], 3600);
				// }
				// $this->load->view('title_container');
		  //   	$this->load->view('header', $data);
		  //   	$this->load->view('client/targetsAndActuals');
		  //   	$this->load->view('footer');
		  //   }
        }
        else
        {
			redirect('','refresh');
		}
    }
}

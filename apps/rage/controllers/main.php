<?php

class Main extends CI_Controller
{
	private $accountid;
	
	function __construct()
	{
		parent::__construct();
		
		$this->load->driver('cache');
		
		$this->accountid = $this->session->userdata('accountid');
	}
	
	public function index()
	{
		if(!$this->input->is_ajax_request())
		{
			$this->benchmark->mark('code_start');
			
			if(!$this->accountid)
			{
				$data['form'] = "frm_register";
				$data['formtitle'] = "Create your Account";
				$data['content'] = $this->load->view("main/index",$data,true);
			}
			else
			{
				$this->load->model('accounts_db');
				$this->load->model('streams_db');
				
				$details = $this->accounts_db->getAccountM(array('_id'=>(int)$this->accountid));
	
				$data['title'] = "Home Page | ".config_item('site_title');	
				$data['cssgroup'] = "loggedin";
				$data['jsgroup'] = "loggedin";
				$data['page'] = 'stream';
				$data['details'] = $details[0];
				$data['streams'] = $this->streams_db->getStream();
				
				$data['content'] = $this->load->view('stream/index',$data,true);
			}
			
			$data['elapse'] = $this->benchmark->elapsed_time('code_start', 'code_end');
			$this->load->vars($data);
			$this->load->view('default',$data);
			$this->minify->html();
        }
        else
        {
			checkSession();
			$this->load->model('accounts_db');
			$this->load->model('streams_db');
			
			$details = $this->accounts_db->getAccountM(array('_id'=>(int)$this->accountid));
			$data['streams'] = $this->streams_db->getStream();
			$details = $this->accounts_db->getAccountM(array('_id'=>$this->accountid));
			$data['details'] = $details[0];
			$this->load->view('stream/widget/w_stream',$data);
		}

	}
	

}

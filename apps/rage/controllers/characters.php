<?php

class Characters extends CI_Controller
{
	private $accountid;
	
	function __construct()
	{
		parent::__construct();
		
		$this->accountid = $this->session->userdata('accountid');
		$this->load->model('accounts_db');
	}
	
	function index()
	{
		$this->benchmark->mark('code_start');
	
		$data['title'] = "Characters | ".config_item('site_title');
		$data['cssgroup'] = "loggedin";
		$data['jsgroup'] = "loggedin";
		$data['page'] 	= 'storage';
		
		$details = $this->accounts_db->getAccountM(array('_id'=>(int)$this->accountid));
		$data['details'] = $details[0];
		
		$this->load->model('char_db');
		$online = $this->char_db->getOnline();
		$data['onlines'] = $online;
		
		if(!$this->input->is_ajax_request())
		{
			if(!$this->accountid) redirect();
		
			$data['content'] = $this->load->view('character/index',$data,true);
			
			$data['elapse'] = $this->benchmark->elapsed_time('code_start', 'code_end');
			$this->load->vars($data);
			$this->load->view('default',$data);
        }
        else
        {
			checkSession();
			
			$data = array();
			$this->load->view('character/widget/w_character',$data);
		}
		$this->minify->html();
	}
	
	function storage()
	{
		$this->benchmark->mark('code_start');
	
		$data['title'] = "Storage | ".config_item('site_title');
		$data['cssgroup'] = "loggedin";
		$data['jsgroup'] = "loggedin";
		$data['page'] 	= 'storage';
		
		$details = $this->accounts_db->getAccountM(array('_id'=>(int)$this->accountid));
		$data['details'] = $details[0];
		
		if(!$this->input->is_ajax_request())
		{
			if(!$this->accountid) redirect();
		
			$data['content'] = $this->load->view('character/storage',$data,true);
			
			$data['elapse'] = $this->benchmark->elapsed_time('code_start', 'code_end');
			$this->load->vars($data);
			$this->load->view('default',$data);
			
        }
        else
        {
			checkSession();
			
			$data = array();
			$this->load->view('character/widget/w_storage',$data);
		}
		$this->minify->html();
	}
	
	function getOnline()
	{
		$this->load->model('char_db');
		$online = $this->char_db->getOnline();
		$data['db'] = $online;
		$data['json'] = $data;
		$this->load->view('ajax/json',$data);

	}
}

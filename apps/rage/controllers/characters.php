<?php

class Characters extends CI_Controller
{
	private $account;
	
	function __construct()
	{
		parent::__construct();
		
		$this->account = $this->session->userdata('accountid');
	}
	
	function index()
	{
		$this->benchmark->mark('code_start');
	
		$data['title'] = "Characters | ".config_item('site_title');
		$data['cssgroup'] = "loggedin";
		$data['jsgroup'] = "loggedin";
		$data['page'] 	= 'storage';
		
		if(!$this->input->is_ajax_request())
		{
			if(!$this->account) redirect();
		
			$data['content'] = $this->load->view('character/index',$data,true);
			
			$data['elapse'] = $this->benchmark->elapsed_time('code_start', 'code_end');
			$this->load->vars($data);
			$this->load->view('default',$data);
			$this->minify->html();
        }
        else
        {
			checkSession();
			
			$data = array();
			$this->load->view('character/widget/w_character',$data);
		}
	}
	
	function storage()
	{
		$this->benchmark->mark('code_start');
	
		$data['title'] = "Storage | ".config_item('site_title');
		$data['cssgroup'] = "loggedin";
		$data['jsgroup'] = "loggedin";
		$data['page'] 	= 'storage';
		
		if(!$this->input->is_ajax_request())
		{
			if(!$this->account) redirect();
		
			$data['content'] = $this->load->view('character/storage',$data,true);
			
			$data['elapse'] = $this->benchmark->elapsed_time('code_start', 'code_end');
			$this->load->vars($data);
			$this->load->view('default',$data);
			$this->minify->html();
        }
        else
        {
			checkSession();
			
			$data = array();
			$this->load->view('character/widget/w_storage',$data);
		}
	}
}

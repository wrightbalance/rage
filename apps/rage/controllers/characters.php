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
		$this->load->helper('array');
		$this->load->helper('jobclass');
	
		$data['title'] = "Characters | ".config_item('site_title');
		$data['cssgroup'] = "loggedin";
		$data['jsgroup'] = "loggedin";
		$data['page'] 	= 'storage';
		
		$details = $this->accounts_db->getAccountM(array('_id'=>(int)$this->accountid));
		$data['details'] = $details[0];
		
		$this->load->model('char_db');
		$online = $this->char_db->getOnline();
		$pvptop = $this->char_db->topPlayer();
		
		$data['onlines'] = $online;
		$data['pvptop'] = $pvptop;
		
		$data['characters'] = $this->char_db->getChar(array('account_id'=>$this->accountid));
	
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
			
			$this->load->vars($data);
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
		
		$this->load->model('char_db');
		$online = $this->char_db->getOnline();
		$pvptop = $this->char_db->topPlayer();
		
		$data['onlines'] = $online;
		$data['pvptop'] = $pvptop;
		
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
			
			$this->load->vars($data);
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
	
	function reset()
	{
		if(!$this->input->is_ajax_request()) exit();
		checkSession();
		
		$this->load->model('char_db');
		
		$action = $this->input->post('action');
		$char_id = $this->input->post('char_id');
		
		$getChar = $this->char_db->getMyChar(array('char_id'=>$char_id,'account_id'=>$this->accountid));
		
		switch($action)
		{
			case "1": $act = "map"; break;
			case "2": $act = "equipment"; break;
			case "3": $act = "hair"; break;
			case "4": $act = "map equipment hair"; break;
		}
		
		if($getChar['online'] == 1)
		{
			$data['message'] = "<span style='color:red'>".$getChar['name']." is currently online. Please logout your account to reset your character</span>";
		}
		else
		{
			$this->char_db->reset($char_id,$this->accountid,$action);
			$data['message'] = $getChar['name']." ".$act." successfully reset";
		}
		
		$data['json'] = $data;
		$this->load->view('ajax/json',$data);
		
	}
}

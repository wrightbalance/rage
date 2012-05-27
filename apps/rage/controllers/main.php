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
		$data['showlogin'] = true;
		
		if($this->accountid)
		{
			$this->load->model('notif_db');
			$this->load->model('accounts_db');
			$this->load->model('streams_db');
				
			$data['isAdmin'] =false;
			
			$groupid = $this->session->userdata('groupid');
			if($groupid >= config_item('group_level')) 
			{
				$data['isAdmin'] = true;
			}
			$data['showlogin'] = false;
			
			$data['news_count'] = $this->notif_db->newsCount(array('category'=>'news'));
			
			$details = $this->accounts_db->getAccount(array('account_id'=>$this->accountid));
			$data['details'] = $details;
			
		}
		$this->load->model('char_db');

		
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
				$data['title'] = "Home Page | ".config_item('site_title');	
				$data['cssgroup'] = "loggedin";
				$data['jsgroup'] = "loggedin";
				$data['page'] = 'stream';
				
				
				$data['streams'] = $this->streams_db->getStream();
				
				$data['content'] = $this->load->view('stream/index',$data,true);
			}
			
			$data['elapse'] = $this->benchmark->elapsed_time('code_start', 'code_end');
			$this->load->vars($data);
			$this->load->view('default',$data);
		
        }
        else
        {
			checkSession();
			$this->load->model('accounts_db');
			$this->load->model('streams_db');
			
			$details = $this->accounts_db->getAccount(array('account_id'=>$this->accountid));
			$data['streams'] = $this->streams_db->getStream();
			$data['details'] = $details;
			$this->load->vars($data);
			$this->load->view('stream/widget/w_stream',$data);
		}
		
		$this->minify->html();
	}
	
	function help()
	{
		$this->benchmark->mark('code_start');
		$this->load->model('accounts_db');

		$data['cssgroup'] = "loggedin";
		$data['jsgroup'] = "loggedin";
		$data['page'] 	= 'help-guide';
		
		$details = $this->accounts_db->getAccount(array('account_id'=>$this->accountid));
		$data['details'] = $details;

		if(!$this->input->is_ajax_request())
		{
			if(!$this->accountid) redirect();
		
			$data['content'] = $this->load->view('main/help',$data,true);
			
			$data['elapse'] = $this->benchmark->elapsed_time('code_start', 'code_end');
			$this->load->vars($data);
			$this->load->view('default',$data);
			
        }
        else
        {
			checkSession();
			
			$this->load->vars($data);
			$this->load->view('main/widget/w_help',$data);
		}
		$this->minify->html();
	}
	

}

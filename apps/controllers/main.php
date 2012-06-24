<?php

class Main extends MY_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->driver('cache');
		$this->load->model('cms_db');
		$this->load->model('char_db');
		$this->load->model('notif_db');
		$this->load->model('streams_db');
		$this->load->model('ranking_db');
		
	}
	
	function index()
	{
		$data['showlogin'] = true;
		
		$data['news'] = $this->cms_db->getNews(array('category'=>'news'),false);

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
				$data['title'] = "Home Page | ".config_item('SiteTitle');	
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

			$data['streams'] = $this->streams_db->getStream();
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
	
			$this->load->vars($data);
			$this->load->view('main/widget/w_help',$data);
		}
		$this->minify->html();
	}
	

}

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
		$data['news'] = $this->cms_db->getNews(array('status'=>1),true,2);

		if(!$this->input->is_ajax_request())
		{
			$this->benchmark->mark('code_start');
			
			$page = "main";
			
			
			
			if(!$this->accountid)
			{
				if(!$page = $this->cache->get($page))
				{
					
				}
				$data['form'] = "frm_register";
				$data['formtitle'] = "Create your Account to Geared CP";
				$data['page_content'] = $this->load->view('main/home',$data,true);
				$data['content'] = $this->load->view("main/index",$data,true);
			}
			else
			{
				$data['title'] = "Home Page | ".config_item('ServerName');	
				$data['cssgroup'] = "loggedin";
				$data['jsgroup'] = "loggedin";
				$data['page'] = 'stream';
				
				
				$data['streams'] = $this->streams_db->getStream(10);
				$data['mod'] = "stream";
				$data['page'] = "index";
				$data['content'] = $this->load->view('layout/content',$data,true);
			}
			
			$data['elapse'] = $this->benchmark->elapsed_time('code_start', 'code_end');
			$this->load->vars($data);
			$this->load->view('default',$data);
		
        }
        else
        {

			$data['streams'] = $this->streams_db->getStream(10);
			$this->load->vars($data);
			$this->load->view("stream/index",$data);
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
	
	function maintenance()
	{
		if(config_item('EnableSite')) redirect();
		
		echo 'Website Maintenance'; exit();
	}
	

}
